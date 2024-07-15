// WRITE A C PROGRAM TO SIMULATE LEXICAL ANALYZER FOR VALIDATING OPERATORS.
#include <stdio.h>
#include <ctype.h>
int isValidIdentifier(char identifier[]);
int main() {
 char identifier[20];
 printf("Enter an identifier: ");
 scanf("%s", identifier);
 if (isValidIdentifier(identifier)) {
 printf("\nIt is a valid identifier\n");
 } else {
 printf("\nIt is not a valid identifier\n");
 }
 return 0;
}
int i;
int isValidIdentifier(char identifier[]) {
 if (!isalpha(identifier[0]) && identifier[0] != '_') {
 return 0; 
 }
 
 for (i = 1; identifier[i] != '\0'; i++) {
 if (!isalnum(identifier[i]) && identifier[i] != '_') {
 return 0; 
 }
 }
 return 1; 
}
