// Write a C program to implement a symbol table.
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>
int main() {
 int i = 0, j = 0, x = 0, n, flag = 0;
 void *p, *add[15];
 char ch, srch, b[15], d[15], c;
 printf("Enter expression terminated by $: ");
 while((c = getchar()) != '$' && i < 15) {
 b[i] = c;
 i++;
 }
 b[i] = '\0'; // Null-terminate the string
 n = i - 1;
 printf("Given expression is: ");
 for (i = 0; i <= n; i++) {
 printf("%c", b[i]);
 }
 printf("\n");
 printf("Symbol table:-\n");
 printf("Symbol\tAddress\t\tType\n");
 for (j = 0; j <= n; j++) {
 c = b[j];
 if (isalpha(c)) {
 if (j == n || strchr("+-*=", b[j+1])) {
 p = malloc(1); // Allocate memory to simulate address storage
 add[x] = p;
 d[x] = c;
 printf("%c\t%p\tidentifier\n", c, p);
 x++;
 }
 }
 }
 printf("Enter the symbol to be searched: ");
 scanf(" %c", &srch); // Note the space before %c to consume any trailing whitespace
 flag = 0;
 for (i = 0; i < x; i++) {
 if (srch == d[i]) {
 printf("Symbol found in the table:\n");
 printf("Symbol\tAddress\n");
 printf("%c\t%p\n", srch, add[i]);
 flag = 1;
 break;
 }
 }
 if (flag == 0) {
 printf("Symbol not found in the table\n");
 }
 return 0;
}
