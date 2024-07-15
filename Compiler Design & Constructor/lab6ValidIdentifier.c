//Write a C program to test a given identifier is valid or not
#include<stdio.h>
//#include<conio.h>
#include<ctype.h>
void main()
{
 char identifier[20];
 int flag, i = 1;
 printf("\n Enter an identifier :");
 gets(identifier);
 if(isalpha(identifier[0]))
 flag = 1;
 else
 printf("\n It is not valid identifier");
 while(identifier[i] != '\0')
 {
 if(!isdigit(identifier[i])&&!isalpha(identifier[i]))
 {
 flag = 0;
 break;
 }
 i++;
 }
 if(flag == 1)
 printf("\n It is a valid identifier");
 //getch();
}
