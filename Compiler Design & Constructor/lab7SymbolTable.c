//Write a C program for implementing symbol table.
#include <stdio.h>
#include <stdlib.h>
#include <string.h> 
#define null 0
int size = 0;
void insert();
void delete();
int search(char lab[]);
void modify();
void display();
struct symbtab {
 char label[10];
 int addr;
 struct symbtab *next;
};
struct symbtab *first = NULL, *last = NULL;
void main() {
 int op;
 char la[10];
 do {
 printf("\nSymbol Table Implementation\n");
 printf("1. Insert\n");
 printf("2. Display\n");
 printf("3. Delete\n");
 printf("4. Search\n");
 printf("5. Modify\n");
 printf("6. End\n");
 printf("Enter your option: ");
 scanf("%d", &op);
 switch (op) {
 case 1:
 insert();
 display();
 break;
 case 2:
 display();
 break;
 case 3:
 delete();
 display();
 break;
 case 4:
 printf("Enter the label to be searched: ");
 scanf("%s", la);
 if (search(la))
 printf("The label is already in the symbol table\n");
 else
 printf("The label is not found in the symbol table\n");
 break;
 case 5:
 modify();
 display();
 break;
 case 6:
 break;
 default:
 printf("Invalid option! Please enter a number between 1 and 6.\n");
 }
 } while (op != 6);
}
void insert() {
 char l[10];
 printf("Enter the label: ");
 scanf("%s", l);
 if (search(l)) {
 printf("The label already exists. Duplicate can't be inserted.\n");
 return;
 }
 struct symbtab *p = (struct symbtab *)malloc(sizeof(struct symbtab));
 strcpy(p->label, l);
 printf("Enter the address: ");
 scanf("%d", &p->addr);
 p->next = NULL;
 if (size == 0) {
 first = p;
 last = p;
 } else {
 last->next = p;
 last = p;
 }
 size++;
}
void display() {
 struct symbtab *p = first;
 printf("Label\t Address\n");
 while (p != NULL) {
 printf("%s\t%d\n", p->label, p->addr);
 p = p->next;
 }
}
int search(char lab[]) {
 struct symbtab *p = first;
 while (p != NULL) {
 if (strcmp(p->label, lab) == 0)
 return 1;
 p = p->next;
 }
 return 0;
}
void modify() {
 char l[10], nl[10];
 int add, choice;
 printf("What do you want to modify?\n");
 printf("1. Only the label\n");
 printf("2. Only the address of a particular label\n");
 printf("3. Both the label and address\n");
 printf("Enter your choice: ");
 scanf("%d", &choice);
 struct symbtab *p = first;
 switch (choice) {
 case 1:
 printf("Enter the old label: ");
 scanf("%s", l);
 if (!search(l)) {
 printf("No such label\n");
 return;
 }
 printf("Enter the new label: ");
 scanf("%s", nl);
 while (p != NULL) {
 if (strcmp(p->label, l) == 0) {
 strcpy(p->label, nl);
 break;
 }
 p = p->next;
 }
 break;
 case 2:
 printf("Enter the label whose address is to be modified: ");
 scanf("%s", l);
 if (!search(l)) {
 printf("No such label\n");
 return;
 }
 printf("Enter the new address: ");
 scanf("%d", &add);
 while (p != NULL) {
 if (strcmp(p->label, l) == 0) {
 p->addr = add;
 break;
 }
 p = p->next;
 }
 break;
 case 3:
 printf("Enter the old label: ");
 scanf("%s", l);
 if (!search(l)) {
 printf("No such label\n");
 return;
 }
 printf("Enter the new label: ");
 scanf("%s", nl);
 printf("Enter the new address: ");
 scanf("%d", &add);
 while (p != NULL) {
 if (strcmp(p->label, l) == 0) {
 strcpy(p->label, nl);
 p->addr = add;
 break;
 }
 p = p->next;
 }
 break;
 default:
 printf("Invalid choice\n");
 }
}
void delete() {
 char l[10];
 printf("Enter the label to be deleted: ");
 scanf("%s", l);
 if (!search(l)) {
 printf("Label not found\n");
 return;
 }
 struct symbtab *p = first, *q = NULL;
 if (strcmp(first->label, l) == 0) {
 first = first->next;
 free(p);
 } else {
 while (p != NULL && strcmp(p->label, l) != 0) {
 q = p;
 p = p->next;
 }
 if (p == last) {
 last = q;
 }
 if (q != NULL) {
 q->next = p->next;
 }
 free(p);
 }
 size--;
}
