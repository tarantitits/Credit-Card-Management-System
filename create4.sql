
CREATE TABLE STAFF
(
	STAFF_NUMBER NUMBER(9) PRIMARY KEY,
	SSN NUMBER(9) NOT NULL UNIQUE,
	STAFF_TYPE VARCHAR2(20) NOT NULL,
	MGR_SSN NUMBER(9),
	USERNAME VARCHAR2(20) NOT NULL UNIQUE,
	PASSWORD VARCHAR2(16) NOT NULL
);

ALTER TABLE STAFF
ADD FOREIGN KEY (MGR_SSN)
REFERENCES STAFF(SSN);

CREATE SEQUENCE SEQ_STAFF_NUMBER
MINVALUE 1425
START WITH 1425
INCREMENT BY 17
CACHE 10;

INSERT INTO STAFF(STAFF_NUMBER, SSN, STAFF_TYPE, USERNAME, PASSWORD)
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,167567983,'MANAGER','mng01','pass01');
INSERT INTO STAFF(STAFF_NUMBER, SSN, STAFF_TYPE, USERNAME, PASSWORD)
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,105428754,'MANAGER','mng02','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,143345859,'EMPLOYEE',167567983,'emp01','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,214582654,'EMPLOYEE',167567983,'emp02','pass01');	
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,945621548,'EMPLOYEE',167567983,'emp03','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,321548657,'EMPLOYEE',167567983,'emp04','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,854257625,'EMPLOYEE',167567983,'emp05','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,326548752,'EMPLOYEE',167567983,'emp06','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,104587522,'EMPLOYEE',167567983,'emp07','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,164278521,'REPRESENTATIVE',167567983,'emp08','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,348753549,'REPRESENTATIVE',167567983,'emp09','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,214862304,'REPRESENTATIVE',167567983,'emp10','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,782145015,'INVESTIGATOR',105428754,'inv01','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,372485120,'INVESTIGATOR',105428754,'inv02','pass01');
INSERT INTO STAFF
VALUES(SEQ_STAFF_NUMBER.NEXTVAL,904508754,'INVESTIGATOR',105428754,'inv03','pass01');

CREATE TABLE STAFF_NAME_SSN
(
	SSN NUMBER(9) NOT NULL,
	NAME VARCHAR2(30) NOT NULL
);

ALTER TABLE STAFF_NAME_SSN
ADD FOREIGN KEY (SSN)
REFERENCES STAFF(SSN);

create or replace procedure addname(n1 in staff_name_ssn.name%type,
	n2 in staff_name_ssn.name%type,
	n3 in staff_name_ssn.name%type,
	n4 in staff_name_ssn.name%type,
	n5 in staff_name_ssn.name%type,
	n6 in staff_name_ssn.name%type,
	n7 in staff_name_ssn.name%type,
	n8 in staff_name_ssn.name%type,
	n9 in staff_name_ssn.name%type,
	n10 in staff_name_ssn.name%type,
	n11 in staff_name_ssn.name%type,
	n12 in staff_name_ssn.name%type,
	n13 in staff_name_ssn.name%type,
	n14 in staff_name_ssn.name%type,
	n15 in staff_name_ssn.name%type)
is
var_ssn staff.ssn%type;
cursor staff_name_ssn_cur is select ssn from staff;
begin
	open staff_name_ssn_cur;
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n1);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n2);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n3);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n4);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n5);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n6);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n7);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n8);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n9);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n10);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n11);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n12);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n13);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n14);
	fetch staff_name_ssn_cur into var_ssn;
	insert into staff_name_ssn values(var_ssn, n15);
	close staff_name_ssn_cur;
end;
/

EXEC ADDNAME('JOHN','ZEYU','JERRY','KEITH','BETTY','LILLY','GRACE','JOSH','SAM','SAMANTHA','ALEX','JACY','JIMMY','NOLA','MARTHA');

DROP PROCEDURE ADDNAME;

CREATE SEQUENCE SEQ_ACCOUNT_NUMBER
MINVALUE 1220944584
START WITH 1220944584
INCREMENT BY 17
CACHE 10;

CREATE TABLE CUSTOMER_ACCOUNT
(
	ACCOUNT_NUMBER NUMBER(10) PRIMARY KEY,
	MAX_CREDIT_LIMIT NUMBER(10,2) NOT NULL,
	INTEREST_RATE NUMBER(4,2) NOT NULL,
	CUSTOMER_SSN NUMBER(9) NOT NULL UNIQUE,
	SQUESTION VARCHAR2(50) NOT NULL,
	SANSWER VARCHAR2(50)NOT NULL,
	USERNAME VARCHAR2(20) NOT NULL UNIQUE,
	PASSWORD VARCHAR2(16) NOT NULL
);

INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,345456984,'QUESTION','ANSWER','CUST01','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,582485764,'QUESTION','ANSWER','CUST02','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,245852412,'QUESTION','ANSWER','CUST03','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,754218653,'QUESTION','ANSWER','CUST04','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,145248542,'QUESTION','ANSWER','CUST05','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,965421587,'QUESTION','ANSWER','CUST06','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,735865421,'QUESTION','ANSWER','CUST07','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,302354862,'QUESTION','ANSWER','CUST08','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,120452753,'QUESTION','ANSWER','CUST09','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,932478521,'QUESTION','ANSWER','CUST10','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,789654123,'QUESTION','ANSWER','CUST11','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,352687452,'QUESTION','ANSWER','CUST12','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,248532154,'QUESTION','ANSWER','CUST13','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,758425862,'QUESTION','ANSWER','CUST14','CPASS01');
INSERT INTO CUSTOMER_ACCOUNT
VALUES(SEQ_ACCOUNT_NUMBER.NEXTVAL,5000.00,0.84,305428720,'QUESTION','ANSWER','CUST15','CPASS01');

CREATE TABLE CUSTOMER_NAME_SSN
(
	SSN NUMBER(9) PRIMARY KEY,
	FNAME VARCHAR2(50) NOT NULL,
	MNAME VARCHAR2(50) DEFAULT '_',
	LNAME VARCHAR2(50) NOT NULL
);

create or replace procedure addname(n1 in customer_name_ssn.fname%type,
	n2 in customer_name_ssn.fname%type,
	n3 in customer_name_ssn.fname%type,
	n4 in customer_name_ssn.fname%type,
	n5 in customer_name_ssn.fname%type,
	n6 in customer_name_ssn.fname%type,
	n7 in customer_name_ssn.fname%type,
	n8 in customer_name_ssn.fname%type,
	n9 in customer_name_ssn.fname%type,
	n10 in customer_name_ssn.fname%type,
	n11 in customer_name_ssn.fname%type,
	n12 in customer_name_ssn.fname%type,
	n13 in customer_name_ssn.fname%type,
	n14 in customer_name_ssn.fname%type,
	n15 in customer_name_ssn.fname%type,
	n16 in customer_name_ssn.lname%type,
	n17 in customer_name_ssn.lname%type,
	n18 in customer_name_ssn.lname%type,
	n19 in customer_name_ssn.lname%type,
	n20 in customer_name_ssn.lname%type,
	n21 in customer_name_ssn.lname%type,
	n22 in customer_name_ssn.lname%type,
	n23 in customer_name_ssn.lname%type,
	n24 in customer_name_ssn.lname%type,
	n25 in customer_name_ssn.lname%type,
	n26 in customer_name_ssn.lname%type,
	n27 in customer_name_ssn.lname%type,
	n28 in customer_name_ssn.lname%type,
	n29 in customer_name_ssn.lname%type,
	n30 in customer_name_ssn.lname%type)
is
var_ssn customer_account.customer_ssn%type;
cursor cust_cur is select customer_ssn from customer_account;
begin
	open cust_cur;
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n1, n2);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n3, n4);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n5, n6);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n7, n8);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n9, n10);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n11, n12);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n13, n14);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n15, n16);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n17, n18);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n19, n20);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n21, n22);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n23, n24);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n25, n26);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n27, n28);
	fetch cust_cur into var_ssn;
	insert into customer_name_ssn(ssn, fname, lname) values(var_ssn, n29, n30);
	close cust_cur;
end;
/

EXEC ADDNAME('rick','bosley','martha','stangel','nick','gonzalves','ricky','rich','johnny','english','norma','williams','bill','gates','george','bush','chris','daughtry','jim','stock','sharrukh','khan','aishwarya','rai','amitabh','bachhan','salma','hayek','isha','shetty');

DROP PROCEDURE ADDNAME;

ALTER TABLE CUSTOMER_ACCOUNT
ADD FOREIGN KEY (CUSTOMER_SSN)
REFERENCES CUSTOMER_NAME_SSN(SSN);

CREATE TABLE STAFF_CUSTOMER_MANAGE
(
	STAFF_NUMBER NUMBER(9) NOT NULL,
	CUSTOMER_SSN NUMBER(9) NOT NULL
);

ALTER TABLE STAFF_CUSTOMER_MANAGE
ADD FOREIGN KEY (STAFF_NUMBER)
REFERENCES STAFF(STAFF_NUMBER);

ALTER TABLE STAFF_CUSTOMER_MANAGE
ADD FOREIGN KEY (CUSTOMER_SSN)
REFERENCES CUSTOMER_NAME_SSN(SSN);

create or replace procedure adddata
is
var_staff_num staff_customer_manage.staff_number%type;
var_cust_ssn staff_customer_manage.customer_ssn%type;
cursor staff_num_cur is select staff_number from staff;
cursor cust_ssn_cur is select ssn from customer_name_ssn;
begin
	open staff_num_cur;
	open cust_ssn_cur;
	loop
		fetch staff_num_cur into var_staff_num;
		exit when staff_num_cur%notfound;
		fetch cust_ssn_cur into var_cust_ssn;
		insert into staff_customer_manage values(var_staff_num, var_cust_ssn);
	end loop;
	close staff_num_cur;
	close cust_ssn_cur;
end;
/

EXEC ADDDATA;

DROP PROCEDURE ADDDATA;

CREATE TABLE CUSTOMER_ADDRESS
(
	CUSTOMER_SSN NUMBER(9) NOT NULL UNIQUE,
	STREET VARCHAR2(30) NOT NULL,
	APT_NO NUMBER(3) DEFAULT 0,
	CITY VARCHAR2(20) NOT NULL,
	ZIP NUMBER(5) NOT NULL
);

ALTER TABLE CUSTOMER_ADDRESS
ADD FOREIGN KEY (CUSTOMER_SSN)
REFERENCES CUSTOMER_NAME_SSN(SSN);

create or replace procedure addadd(s1 in customer_address.street%type,
	a1 in customer_address.apt_no%type,
	c1 in customer_address.city%type,
	z1 in customer_address.zip%type,
	s2 in customer_address.street%type,
	a2 in customer_address.apt_no%type,
	c2 in customer_address.city%type,
	z2 in customer_address.zip%type,
	s3 in customer_address.street%type,
	a3 in customer_address.apt_no%type,
	c3 in customer_address.city%type,
	z3 in customer_address.zip%type,
	s4 in customer_address.street%type,
	a4 in customer_address.apt_no%type,
	c4 in customer_address.city%type,
	z4 in customer_address.zip%type,
	s5 in customer_address.street%type,
	a5 in customer_address.apt_no%type,
	c5 in customer_address.city%type,
	z5 in customer_address.zip%type,
	s6 in customer_address.street%type,
	a6 in customer_address.apt_no%type,
	c6 in customer_address.city%type,
	z6 in customer_address.zip%type,
	s7 in customer_address.street%type,
	a7 in customer_address.apt_no%type,
	c7 in customer_address.city%type,
	z7 in customer_address.zip%type,
	s8 in customer_address.street%type,
	a8 in customer_address.apt_no%type,
	c8 in customer_address.city%type,
	z8 in customer_address.zip%type,
	s9 in customer_address.street%type,
	a9 in customer_address.apt_no%type,
	c9 in customer_address.city%type,
	z9 in customer_address.zip%type,
	s10 in customer_address.street%type,
	a10 in customer_address.apt_no%type,
	c10 in customer_address.city%type,
	z10 in customer_address.zip%type,
	s11 in customer_address.street%type,
	a11 in customer_address.apt_no%type,
	c11 in customer_address.city%type,
	z11 in customer_address.zip%type,
	s12 in customer_address.street%type,
	a12 in customer_address.apt_no%type,
	c12 in customer_address.city%type,
	z12 in customer_address.zip%type,
	s13 in customer_address.street%type,
	a13 in customer_address.apt_no%type,
	c13 in customer_address.city%type,
	z13 in customer_address.zip%type,
	s14 in customer_address.street%type,
	a14 in customer_address.apt_no%type,
	c14 in customer_address.city%type,
	z14 in customer_address.zip%type,
	s15 in customer_address.street%type,
	a15 in customer_address.apt_no%type,
	c15 in customer_address.city%type,
	z15 in customer_address.zip%type
)
is
var_ssn customer_name_ssn.ssn%type;
cursor ssn_cur is select ssn from customer_name_ssn;
begin
	open ssn_cur;
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s1, a1, c1, z1);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s2, a2, c2, z2);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s3, a3, c3, z3);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s4, a4, c4, z4);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s5, a5, c5, z5);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s6, a6, c6, z6);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s7, a7, c7, z7);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s8, a8, c8, z8);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s9, a9, c9, z9);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s10, a10, c10, z10);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s11, a11, c11, z11);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s12, a12, c12, z12);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s13, a13, c13, z13);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s14, a14, c14, z14);
	fetch ssn_cur into var_ssn;
	insert into customer_address values(var_ssn, s15, a15, c15, z15);
	close ssn_cur;
end;
/

exec addadd('ralston',301,'fremont',94538,'rector',302,'mountain view',97485,'hastings',303,'diamondbar',98463,'lexington',304,'Peralta',98745,'perry',305,'irvine',94537,'greenwich',306,'warmsprings',91234,'guardino',307,'sunnywale',96754,'cherry',308,'santateresa',98534,'pick',309,'paloalto',97645,'sugar',310,'sanjose',98473,'murray',311,'ardernwood',91234,'davis street',312,'oakland',95647,'parisar lane',313,'sanfrancisco',98371,'Austin drive',314,'hayward',96547,'seeren common',315,'unioncity',96654);

drop procedure addadd;

CREATE TABLE STAFF_ACCOUNT_MANAGE
(
	STAFF_NUMBER NUMBER(9) NOT NULL,
	ACCOUNT_NUMBER NUMBER(10) NOT NULL
);

ALTER TABLE STAFF_ACCOUNT_MANAGE
ADD FOREIGN KEY (STAFF_NUMBER)
REFERENCES STAFF(STAFF_NUMBER);

ALTER TABLE STAFF_ACCOUNT_MANAGE
ADD FOREIGN KEY (ACCOUNT_NUMBER)
REFERENCES CUSTOMER_ACCOUNT(ACCOUNT_NUMBER);

create or replace procedure adddata
is
var_staff_num staff_account_manage.staff_number%type;
var_acct_num staff_account_manage.account_number%type;
cursor staff_num_cur is select staff_number from staff;
cursor acct_num_cur is select account_number from customer_account;
begin
	open staff_num_cur;
	open acct_num_cur;
	loop
		fetch staff_num_cur into var_staff_num;
		exit when staff_num_cur%notfound;
		fetch acct_num_cur into var_acct_num;
		insert into staff_account_manage values(var_staff_num, var_acct_num);
	end loop;
	close staff_num_cur;
	close acct_num_cur;
end;
/

EXEC ADDDATA;

DROP PROCEDURE ADDDATA;

CREATE TABLE CUSTOMER_PHONE
(
	CUSTOMER_SSN NUMBER(9) NOT NULL,
	PHONE NUMBER(10) NOT NULL
);

ALTER TABLE CUSTOMER_PHONE
ADD FOREIGN KEY (CUSTOMER_SSN)
REFERENCES CUSTOMER_NAME_SSN(SSN);

create or replace procedure addphone(n1 in customer_phone.phone%type,
	n2 in customer_phone.phone%type,
	n3 in customer_phone.phone%type,
	n4 in customer_phone.phone%type,
	n5 in customer_phone.phone%type,
	n6 in customer_phone.phone%type,
	n7 in customer_phone.phone%type,
	n8 in customer_phone.phone%type,
	n9 in customer_phone.phone%type,
	n10 in customer_phone.phone%type,
	n11 in customer_phone.phone%type,
	n12 in customer_phone.phone%type,
	n13 in customer_phone.phone%type,
	n14 in customer_phone.phone%type,
	n15 in customer_phone.phone%type)
is
var_ssn customer_name_ssn.ssn%type;
cursor customer_ssn_cur is select ssn from customer_name_ssn;
begin
	open customer_ssn_cur;
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n1);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n2);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n3);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n4);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n5);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n6);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n7);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n8);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n9);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n10);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n11);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n12);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n13);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n14);
	fetch customer_ssn_cur into var_ssn;
	insert into customer_phone values(var_ssn, n15);
	close customer_ssn_cur;
end;
/

EXEC ADDPHONE(8457589654,4521402548,2548542365,1024521458,5425876321,4584658956,3078054098,4508202584,9954102587,7854236598,3254125420,1425413652,2587413698,9876542015,4102548563);

DROP PROCEDURE ADDPHONE;

create table statement
(
	statement_number number(4) primary key,
	account_number number(10) not null,
	statement_date date not null,
	available_credit_limit number(4) not null,
	available_cash_limit number(4) not null,
	minimum_payment number(4) not null,
	outstanding_balance number(4) not null
);

alter table statement
add foreign key (account_number)
references customer_account(account_number);

create sequence seq_statement
minvalue 1524
start with 15424
increment by 7
cache 10;

create table credit_card
(
	cd_number number(16) primary key,
	account_number number(10) not null,
	issue_date date not null,
	valid_thru date not null,
	cvc number(3) not null unique,
	pin number(6) not null,
	status varchar(9) not null
);

alter table credit_card
add foreign key (account_number)
references customer_account(account_number);

create sequence seq_cd_number
minvalue 7001325496462154
start with 7001325496462154
increment by 357
cache 10;

create sequence seq_cvc
minvalue 101
start with 101
increment by 2
cache 10;

create sequence seq_pin
minvalue 100001
start with 100005
increment by 17
cache 10;

create or replace procedure addcard
is
var_count number:=15;
var_acct_num customer_account.account_number%type;
cursor acct_cur is select account_number from customer_account;
begin
	open acct_cur;
	loop
		fetch acct_cur into var_acct_num;
		exit when acct_cur%notfound;
		insert into credit_card values(seq_cd_number.nextval, var_acct_num, sysdate - var_count, sysdate - var_count + 1095, seq_cvc.nextval, seq_pin.nextval, 'ACTIVE');
		var_count:= var_count+1;
	end loop;
	close acct_cur;
end;
/

exec addcard;

drop procedure addcard;

create table activity
(
	activity_number number(7) primary key,
	account_number number(10) not null,
	staff_number number(9),
	activity_date date not null,
	activity_type varchar2(1) not null,
	merchant varchar2(20),
	amount number(10,2) not null,
	cd_number number(16) not null
);

create sequence seq_activity
minvalue 1021034
start with 1021034
increment by 2
cache 10;

alter table activity
add foreign key (account_number)
references customer_account(account_number);

alter table activity
add foreign key (staff_number)
references staff(staff_number);

alter table activity
add foreign key (cd_number)
references credit_card(cd_number);

create table customer_service
(
	customer_service_number number(5) primary key,
	customer_ssn number(9) not null,
	staff_number number(9) not null,
	service_type varchar(10) not null,
	service_date date not null,
	resolution varchar(50) not null
);

alter table customer_service
add foreign key (customer_ssn)
references customer_name_ssn(ssn);

alter table customer_service
add foreign key (staff_number)
references staff(staff_number);

create sequence seq_csn
minvalue 65824
start with 65824
increment by 1
cache 10;

create table replace_credit_card
(
	customer_service_number number(5) not null unique,
	customer_ssn number(9) not null,
	cd_number number(16) not null
);

alter table replace_credit_card
add foreign key (customer_service_number)
references customer_service(customer_service_number);

alter table replace_credit_card
add foreign key (customer_ssn)
references customer_name_ssn(ssn);

alter table replace_credit_card
add foreign key (cd_number)
references credit_card(cd_number);

create table investigation
(
	investigation_number number(6) primary key,
	customer_service_number number(5) not null,
	customer_ssn number(9) not null,
	staff_number number(9),
	activity_number number(7),
	investigation_date date,
	description varchar2(110) not null,
	disposition varchar2(20) not null
);

alter table investigation
add foreign key (customer_service_number)
references customer_service(customer_service_number);

alter table investigation
add foreign key (customer_ssn)
references customer_name_ssn(ssn);

alter table investigation
add foreign key (staff_number)
references staff(staff_number);

alter table investigation
add foreign key (activity_number)
references activity(activity_number);

create sequence seq_investigation
minvalue 105241
start with 105241
increment by 3
cache 10;
/


CREATE OR REPLACE FUNCTION createAcct
(cSSN CUSTOMER_ACCOUNT.CUSTOMER_SSN%TYPE,
cfName CUSTOMER_NAME_SSN.FNAME%TYPE,
cmName CUSTOMER_NAME_SSN.MNAME%TYPE,
clName CUSTOMER_NAME_SSN.LNAME%TYPE,
cStreet CUSTOMER_ADDRESS.STREET%TYPE,
cAptno CUSTOMER_ADDRESS.APT_NO%TYPE,
cCity CUSTOMER_ADDRESS.CITY%TYPE,
cZip CUSTOMER_ADDRESS.ZIP%TYPE,
cPhone CUSTOMER_PHONE.PHONE%TYPE,
cstaffno STAFF_CUSTOMER_MANAGE.STAFF_NUMBER%TYPE)
RETURN CUSTOMER_ACCOUNT.ACCOUNT_NUMBER%TYPE
IS
cacctno CUSTOMER_ACCOUNT.ACCOUNT_NUMBER%TYPE;
maxcreditlimit CUSTOMER_ACCOUNT.MAX_CREDIT_LIMIT%TYPE DEFAULT 5000;
interestrate CUSTOMER_ACCOUNT.INTEREST_RATE%TYPE DEFAULT 0.84;
secquestion CUSTOMER_ACCOUNT.SQUESTION%TYPE DEFAULT 'QUESTION';
secanswer CUSTOMER_ACCOUNT.SANSWER%TYPE DEFAULT 'ANSWER';
tmpuname CUSTOMER_ACCOUNT.USERNAME%TYPE;
tmppword CUSTOMER_ACCOUNT.PASSWORD%TYPE DEFAULT 'PASS01';
BEGIN
tmpuname := cfName||clName;
INSERT INTO CUSTOMER_NAME_SSN (SSN, FNAME, MNAME, LNAME)
VALUES (cSSN, cfName, cmName, clName);
INSERT INTO CUSTOMER_ACCOUNT (ACCOUNT_NUMBER, MAX_CREDIT_LIMIT, INTEREST_RATE, CUSTOMER_SSN, SQUESTION, SANSWER, USERNAME, PASSWORD)
VALUES (SEQ_ACCOUNT_NUMBER.NEXTVAL, maxcreditlimit, interestrate, cSSN, secquestion, secanswer, tmpuname, tmppword);
INSERT INTO CUSTOMER_ADDRESS (CUSTOMER_SSN, STREET, APT_NO, CITY, ZIP)
VALUES (cSSN, cStreet, cAptno, cCity, cZip);
INSERT INTO CUSTOMER_PHONE (CUSTOMER_SSN, PHONE)
VALUES (cSSN, cPhone);
INSERT INTO STAFF_CUSTOMER_MANAGE (STAFF_NUMBER, CUSTOMER_SSN)
VALUES (cstaffno, cSSN);

SELECT ACCOUNT_NUMBER
INTO cacctno
FROM CUSTOMER_ACCOUNT
WHERE CUSTOMER_SSN = cSSN;

RETURN(cacctno);
END;
/

CREATE OR REPLACE FUNCTION createCard (ccacctno CUSTOMER_ACCOUNT.ACCOUNT_NUMBER%TYPE)
        RETURN CREDIT_CARD.CD_NUMBER%TYPE
        IS ccdno CREDIT_CARD.CD_NUMBER%TYPE;
BEGIN
INSERT INTO CREDIT_CARD (CD_NUMBER, ACCOUNT_NUMBER, ISSUE_DATE, VALID_THRU, CVC, PIN, STATUS)
VALUES (SEQ_CD_NUMBER.NEXTVAL, ccacctno, CURRENT_DATE, CURRENT_DATE + 1095, SEQ_CVC.NEXTVAL, SEQ_PIN.NEXTVAL, 'INACTIVE');

SELECT LAST_VALUE(CD_NUMBER) OVER (ORDER BY ISSUE_DATE)
INTO ccdno
FROM CREDIT_CARD
WHERE ACCOUNT_NUMBER = ccacctno;

RETURN(ccdno);
END;
/

CREATE OR REPLACE PROCEDURE createNewAcct (nSsn CUSTOMER_ACCOUNT.CUSTOMER_SSN%TYPE,
nfName CUSTOMER_NAME_SSN.FNAME%TYPE,
nmName CUSTOMER_NAME_SSN.MNAME%TYPE,
nlName CUSTOMER_NAME_SSN.LNAME%TYPE,
nStreet CUSTOMER_ADDRESS.STREET%TYPE,
nAptno CUSTOMER_ADDRESS.APT_NO%TYPE,
nCity CUSTOMER_ADDRESS.CITY%TYPE,
nZip CUSTOMER_ADDRESS.ZIP%TYPE,
nPhone CUSTOMER_PHONE.PHONE%TYPE,
nStaffno STAFF_CUSTOMER_MANAGE.STAFF_NUMBER%TYPE)
AS
newacctno CUSTOMER_ACCOUNT.ACCOUNT_NUMBER%TYPE;
newcardno CREDIT_CARD.CD_NUMBER%TYPE;
BEGIN
newacctno := createAcct(nSsn, nfName, nmName, nlName, nStreet, nAptno, nCity, nZip, nPhone, nStaffno);
newcardno := createCard(newacctno);
END;
/

CREATE OR REPLACE PROCEDURE replaceCard(rpacctno CUSTOMER_ACCOUNT.ACCOUNT_NUMBER%TYPE, rpstatus CREDIT_CARD.STATUS%TYPE, rpcdno OUT CREDIT_CARD.CD_NUMBER%TYPE)
AS
oldcdno CREDIT_CARD.CD_NUMBER%TYPE;
BEGIN
SELECT LAST_VALUE(CD_NUMBER) OVER (ORDER BY ISSUE_DATE)
INTO oldcdno
FROM CREDIT_CARD
WHERE ACCOUNT_NUMBER = rpacctno;

UPDATE CREDIT_CARD
SET STATUS = rpstatus
WHERE ACCOUNT_NUMBER = rpacctno AND CD_NUMBER = oldcdno;
rpcdno := createCard(rpacctno);
END;
/

CREATE OR REPLACE PACKAGE customer_var
AS
TYPE activitycursor IS REF CURSOR RETURN ACTIVITY%ROWTYPE;
TYPE summaryrecord IS RECORD (
billdate STATEMENT.STATEMENT_DATE%TYPE,
balance ACTIVITY.AMOUNT%TYPE,
minpay ACTIVITY.AMOUNT%TYPE,
avclimit CUSTOMER_ACCOUNT.MAX_CREDIT_LIMIT%TYPE,
lastpayamount ACTIVITY.AMOUNT%TYPE,
lastpaydate ACTIVITY.ACTIVITY_DATE%TYPE);
END customer_var;
/

CREATE OR REPLACE PROCEDURE listactivityrange(ahacctno CUSTOMER_ACCOUNT.ACCOUNT_NUMBER%TYPE, datefrom ACTIVITY.ACTIVITY_DATE%TYPE, dateto ACTIVITY.ACTIVITY_DATE%TYPE, actrangecursor IN OUT customer_var.activitycursor)
AS
BEGIN
OPEN actrangecursor FOR
SELECT *
FROM ACTIVITY
WHERE ACCOUNT_NUMBER = ahacctno AND ACTIVITY_DATE
BETWEEN datefrom AND dateto;
CLOSE actrangecursor;
END listactivityrange;
/

CREATE OR REPLACE PROCEDURE randomtransact(rancdno CREDIT_CARD.CD_NUMBER%TYPE, randate DATE)
AS
TYPE trnxinst IS RECORD (
rndamt ACTIVITY.AMOUNT%TYPE,
rndmerc ACTIVITY.MERCHANT%TYPE
);
transact trnxinst;
ranmrc VARCHAR2(6);
ranmrn VARCHAR2(6);
tnxacctno CREDIT_CARD.ACCOUNT_NUMBER%TYPE;
BEGIN
ranmrc := dbms_random.string('a',5);
ranmrn := to_char(trunc(dbms_random.value(1,6)), '99999');
transact.rndamt := trunc(dbms_random.value(1,1001));
transact.rndmerc := ranmrc||ranmrn;

SELECT ACCOUNT_NUMBER
INTO tnxacctno
FROM CREDIT_CARD
WHERE CD_NUMBER = rancdno;

INSERT INTO ACTIVITY
VALUES (SEQ_ACTIVITY.NEXTVAL, tnxacctno, NULL, randate, 'T', transact.rndmerc, transact.rndamt, rancdno);

END;
/
