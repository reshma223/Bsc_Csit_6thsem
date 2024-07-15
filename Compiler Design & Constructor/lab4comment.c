/*Write a C program to identify wheather a given line is a comment or not */
#include <stdio.h>
#include <string.h>
int main() {
 char comment[100];
 int i, a = 0;
 printf("Enter a comment: ");
 fgets(comment, sizeof(comment), stdin);
 if (comment[0] == '/') {
 if (comment[1] == '/') {
 printf("\nIt is a comment");
 } else if (comment[1] == '*') {
 // Check for multi-line comment
 for (i = 2; i < strlen(comment) - 1; i++) {
 if (comment[i] == '*' && comment[i + 1] == '/') {
 printf("\nIt is a comment");
 a = 1;
 break;
 }
 }
 if (a == 0) {
 printf("\n It is not a complete comment");
 }
 } else {
 printf("\nIt is not a comment");
 }
 } else {
 printf("\nIt is not a comment");
 }
 return 0;
}
