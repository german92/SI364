-- German Ostaszynski
-- SI 364, Homework 7


/**************************************************************
1.   IDs, names, and GPAs of students with GPA > 3.6
**************************************************************/

SELECT sID, sName, GPA
INTO OUTFILE 'Hw7-1.txt'
FROM Student
WHERE GPA > 3.6;

/**************************************************************
2.   Student names and majors for which they've applied - no duplicates
**************************************************************/

SELECT DISTINCT sName, major
INTO OUTFILE 'Hw7-2.txt'
FROM Student, Apply
WHERE Student.sID = Apply.sID;

/**************************************************************
3.  Names and GPAs of students with sizeHS < 1000 applying to
  CS at Stanford, and the application decision
**************************************************************/

SELECT sName, GPA, decision
INTO OUTFILE 'Hw7-3.txt'
FROM Student, Apply
WHERE sizeHS < 1000 AND major = 'CS' AND cName = 'Stanford' AND Student.sID = Apply.sID;

/**************************************************************
4.  All large campuses (enrollment over 20000) with CS applicants -
no duplicates
**************************************************************/

SELECT DISTINCT College.cName
INTO OUTFILE 'Hw7-4.txt'
FROM College, Apply
WHERE enrollment > 20000 AND major = 'CS' AND Apply.cName = College.cName;

/**************************************************************
5.  Application information, sorted by highest gpa
**************************************************************/

SELECT Student.sID, sName, GPA, Apply.cName, enrollment
INTO OUTFILE 'Hw7-5.txt'
FROM Student, College, Apply
WHERE Student.sID = Apply.sID AND College.cName = Apply.cName
ORDER BY GPA DESC;

/**************************************************************
6.  Applicants to bio majors
**************************************************************/

SELECT sID, major 
INTO OUTFILE 'Hw7-6.txt'
FROM Apply
WHERE major = 'biology' OR major = 'bioengineering' OR major = 'marine biology'; 

/**************************************************************
7.  Select * cross-product of Students and Colleges
**************************************************************/

SELECT *
INTO OUTFILE 'Hw7-7.txt'
FROM Student, College;

/**************************************************************
8.  Add scaled GPA based on sizeHS GPA*(sizeHS/1000.0)
**************************************************************/

SELECT *, GPA*(sizeHS/1000.0)
INTO OUTFILE 'Hw7-8.txt'
FROM Student;

/**************************************************************
9. Rename result attribute as scaledGPA and return the first 5
**************************************************************/

SELECT *, GPA*(sizeHS/1000.0) AS scaleGPA
INTO OUTFILE 'Hw7-9.txt'
FROM Student
LIMIT 0,5;


/**************************************************************
10. Show all students and the number of colleges they applied to.  Make sure to match the column names
**************************************************************/

SELECT Student.sName AS Name, COUNT(Apply.sID) AS Applications  
INTO OUTFILE 'Hw7-10.txt'
FROM Student, Apply
WHERE Student.sID = Apply.sID group by Apply.sID;


