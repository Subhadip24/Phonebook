#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>
#include <stdbool.h>

#define NAME_LEN 50
#define PHONE_LEN 15
#define FILE_NAME "/data/data/com.termux/files/home/www/phonebook_data/contacts.txt"

typedef struct ContactNode {
    char name[NAME_LEN];
    char phone[PHONE_LEN];
    struct ContactNode *left, *right;
} ContactNode;

ContactNode* root = NULL;

bool is_valid_phone(const char *phone) {
    if (strlen(phone) != 10) return false;
    for (int i = 0; phone[i]; i++) {
        if (!isdigit(phone[i])) return false;
    }
    return true;
}

bool phone_exists(ContactNode *root, const char *phone) {
    if (!root) return false;
    if (strcmp(root->phone, phone) == 0) return true;
    return phone_exists(root->left, phone) || phone_exists(root->right, phone);
}

ContactNode* search(ContactNode* root, const char* name) {
    if (!root) return NULL;
    int cmp = strcmp(name, root->name);
    if (cmp == 0) return root;
    else if (cmp < 0) return search(root->left, name);
    else return search(root->right, name);
}

ContactNode* create_node(const char *name, const char *phone) {
    ContactNode *node = malloc(sizeof(ContactNode));
    strncpy(node->name, name, NAME_LEN - 1);
    node->name[NAME_LEN - 1] = '\0';
    strncpy(node->phone, phone, PHONE_LEN - 1);
    node->phone[PHONE_LEN - 1] = '\0';
    node->left = node->right = NULL;
    return node;
}

ContactNode* insert(ContactNode* root, const char *name, const char *phone) {
    if (!root) return create_node(name, phone);
    int cmp = strcmp(name, root->name);
    if (cmp < 0) root->left = insert(root->left, name, phone);
    else if (cmp > 0) root->right = insert(root->right, name, phone);
    return root;
}

void in_order(ContactNode *root) {
    if (!root) return;
    in_order(root->left);
    printf("%s,%s\n", root->name, root->phone);
    in_order(root->right);
}

void unified_search(ContactNode *root, const char *query) {
    if (!root) return;
    unified_search(root->left, query);
    if (strcasestr(root->name, query) || strstr(root->phone, query)) {
        printf("%s,%s\n", root->name, root->phone);
    }
    unified_search(root->right, query);
}

ContactNode* find_min(ContactNode* root) {
    while (root && root->left) root = root->left;
    return root;
}

ContactNode* delete(ContactNode* root, const char *name) {
    if (!root) return NULL;
    int cmp = strcmp(name, root->name);
    if (cmp < 0) root->left = delete(root->left, name);
    else if (cmp > 0) root->right = delete(root->right, name);
    else {
        if (!root->left) {
            ContactNode *temp = root->right;
            free(root);
            return temp;
        }
        if (!root->right) {
            ContactNode *temp = root->left;
            free(root);
            return temp;
        }
        ContactNode *temp = find_min(root->right);
        strcpy(root->name, temp->name);
        strcpy(root->phone, temp->phone);
        root->right = delete(root->right, temp->name);
    }
    return root;
}

void save_contacts_helper(ContactNode *root, FILE *fp) {
    if (!root) return;
    save_contacts_helper(root->left, fp);
    fprintf(fp, "%s,%s\n", root->name, root->phone);
    save_contacts_helper(root->right, fp);
}

void save_contacts() {
    FILE *fp = fopen(FILE_NAME, "w");
    if (!fp) {
        printf("ERROR: Could not save contacts\n");
        return;
    }
    save_contacts_helper(root, fp);
    fclose(fp);
}

void load_contacts() {
    FILE *fp = fopen(FILE_NAME, "r");
    if (!fp) return;
    char name[NAME_LEN], phone[PHONE_LEN];
    while (fscanf(fp, " %49[^,],%14[^\n]", name, phone) == 2) {
        root = insert(root, name, phone);
    }
    fclose(fp);
}

void handle_command(int argc, char *argv[]) {
    if (argc < 2) {
        printf("ERROR: No command specified\n");
        return;
    }

    if (strcmp(argv[1], "add") == 0 && argc == 4) {
        if (!is_valid_phone(argv[3])) {
            printf("ERROR: Phone must be 10 digits\n");
            return;
        }
        if (phone_exists(root, argv[3])) {
            printf("ERROR: Phone number already exists\n");
            return;
        }
        root = insert(root, argv[2], argv[3]);
        save_contacts();
        printf("SUCCESS: Added %s\n", argv[2]);
    }
    else if (strcmp(argv[1], "list") == 0) {
        if (!root) {
            printf("No contacts found\n");
        } else {
            in_order(root);
        }
    }
    else if (strcmp(argv[1], "search") == 0 && argc == 3) {
        unified_search(root, argv[2]);
    }
    else if (strcmp(argv[1], "edit") == 0 && argc == 4) {
        ContactNode *target = search(root, argv[2]);
        if (!target) {
            printf("ERROR: Contact not found\n");
            return;
        }
        if (!is_valid_phone(argv[3])) {
            printf("ERROR: Phone must be 10 digits\n");
            return;
        }
        if (strcmp(target->phone, argv[3]) != 0 && phone_exists(root, argv[3])) {
            printf("ERROR: New phone number already exists\n");
            return;
        }
        strncpy(target->phone, argv[3], PHONE_LEN - 1);
        target->phone[PHONE_LEN - 1] = '\0';
        save_contacts();
        printf("SUCCESS: Updated %s\n", argv[2]);
    }
    else if (strcmp(argv[1], "delete") == 0 && argc == 3) {
        if (!search(root, argv[2])) {
            printf("ERROR: Contact not found\n");
            return;
        }
        root = delete(root, argv[2]);
        save_contacts();
        printf("SUCCESS: Deleted %s\n", argv[2]);
    }
    else {
        printf("ERROR: Invalid command or arguments\n");
    }
}

int main(int argc, char *argv[]) {
    system("mkdir -p /data/data/com.termux/files/home/www/phonebook_data");
    load_contacts();

    if (argc > 1) {
        handle_command(argc, argv);
        return 0;
    }

    printf("Phonebook CLI Interface\n");
    printf("Commands:\n");
    printf("  add [name] [phone]\n");
    printf("  list\n");
    printf("  search [query]\n");
    printf("  edit [name] [new_phone]\n");
    printf("  delete [name]\n");
    return 0;
}
