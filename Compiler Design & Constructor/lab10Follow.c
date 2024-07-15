// WRITE A C PROGRAM COMPUTATION OF FOLLOW.
#include <stdio.h>
#include <ctype.h>
#include <string.h>
void FIRST(char[], char);
void FOLLOW(char[], char);
void addToResultSet(char[], char);
int numOfProductions;
char productionSet[10][10];
char firstSet[10][10];
void main() 
{
 int i;
 char choice;
 char ch;
 char result[20];
 printf("How many number of productions?: ");
 scanf("%d", &numOfProductions);
 for (i = 0; i < numOfProductions; i++) {
 printf("Enter production number %d: ", i + 1);
 scanf("%s", productionSet[i]);
 }
 do {
 printf("Find the FOLLOW of: ");
 scanf(" %c", &ch);
 FOLLOW(result, ch);
 printf("\nFOLLOW(%c) = {", ch);
 for (i = 0; result[i] != '\0'; i++) {
 printf("%c ", result[i]);
 }
 printf("}\n");
 printf("Press 'y' to continue: ");
 scanf(" %c", &choice);
 } while (choice == 'y' || choice == 'Y');

}
void FIRST(char* Result, char ch) {
 int i, j, k;
 char subResult[20];
 int foundEpsilon;
 subResult[0] = '\0';
 Result[0] = '\0';
 if (!isupper(ch)) {
 addToResultSet(Result, ch);
 return;
 }
 for (i = 0; i < numOfProductions; i++) {
 if (productionSet[i][0] == ch) {
 if (productionSet[i][2] == '$') {
 addToResultSet(Result, '$');
 } else {
 j = 2;
 while (productionSet[i][j] != '\0') {
 foundEpsilon = 0;
 FIRST(subResult, productionSet[i][j]);
 for (k = 0; subResult[k] != '\0'; k++) {
 addToResultSet(Result, subResult[k]);
 }
 for (k = 0; subResult[k] != '\0'; k++) {
 if (subResult[k] == '$') {
 foundEpsilon = 1;
 break;
 }
 }
 if (!foundEpsilon) {
 break;
 }
 j++;
 }
 }
 }
 }
}
void FOLLOW(char* Result, char ch) {
 int i, j, k;
 char subResult[20];
 Result[0] = '\0';
 if (productionSet[0][0] == ch) {
 addToResultSet(Result, '$');
 }
 for (i = 0; i < numOfProductions; i++) {
 for (j = 2; j < strlen(productionSet[i]); j++) {
 if (productionSet[i][j] == ch) {
 if (productionSet[i][j + 1] != '\0') {
 FIRST(subResult, productionSet[i][j + 1]);
 for (k = 0; subResult[k] != '\0'; k++) {
 if (subResult[k] != '$') {
 addToResultSet(Result, subResult[k]);
 } else {
 if (productionSet[i][j + 2] == '\0' && productionSet[i][0] != 
ch) {
 FOLLOW(subResult, productionSet[i][0]);
 for (k = 0; subResult[k] != '\0'; k++) {
 addToResultSet(Result, subResult[k]);
 }
 }
 }
 }
 }
 if (productionSet[i][j + 1] == '\0' && productionSet[i][0] != ch) {
 FOLLOW(subResult, productionSet[i][0]);
 for (k = 0; subResult[k] != '\0'; k++) {
 addToResultSet(Result, subResult[k]);
 }
 }
 }
 }
 }
}
void addToResultSet(char Result[], char val) {
 int k;
 for (k = 0; Result[k] != '\0'; k++) {
 if (Result[k] == val) {
 return;
 }
 }
 Result[k] = val;
 Result[k + 1] = '\0';
}
