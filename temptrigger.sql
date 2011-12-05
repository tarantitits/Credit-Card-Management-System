CREATE OR REPLACE TRIGGER MAXOUT_CREDIT
  BEFORE INSERT ON ACTIVITY
    FOR EACH ROW
DECLARE
  sumtransaction        number(10,2);
  sumpay        	number(10,2);
  outstandingbal        number(10,2);
  avclimit        number(10,2);
  mxclimit		number(10,2);
  MAXING_OUT     	EXCEPTION;
  MAXED_OUT			EXCEPTION;
  NO_PAYMENT		EXCEPTION;
  NO_TRANSACTIONS	EXCEPTION;
  CURSOR transact_cursor (acctno CREDIT_CARD.ACCOUNT_NUMBER%TYPE) IS
    SELECT SUM(AMOUNT) FROM ACTIVITY WHERE ACCOUNT_NUMBER = acctno AND ACTIVITY_TYPE = 'T' ;
  CURSOR payment_cursor (acctno CREDIT_CARD.ACCOUNT_NUMBER%TYPE) IS
    SELECT SUM(AMOUNT) FROM ACTIVITY WHERE ACCOUNT_NUMBER = acctno AND ACTIVITY_TYPE = 'P' ;
BEGIN
  SELECT MAX_CREDIT_LIMIT INTO mxclimit FROM CUSTOMER_ACCOUNT WHERE ACCOUNT_NUMBER = :NEW.ACCOUNT_NUMBER;
  OPEN transact_cursor (:NEW.ACCOUNT_NUMBER);
  FETCH transact_cursor INTO sumtransaction;
  IF transact_cursor%FOUND THEN
	sumtransaction := 0;
    RAISE NO_TRANSACTIONS;
  END IF;
  OPEN payment_cursor (:NEW.ACCOUNT_NUMBER);
  FETCH payment_cursor INTO sumpay;
  IF payment_cursor%FOUND THEN
	sumpay := 0;
    RAISE NO_PAYMENT;
  END IF;
  outstandingbal := (sumtransaction - sumpay);
  IF (outstandingbal > 0) THEN
	  avclimit := (mxclimit - outstandingbal);
	  IF (avclimit > 0) THEN
		  IF (:NEW.AMOUNT > avclimit) THEN
			RAISE MAXING_OUT;
		  END IF;
	  ELSE
		RAISE MAXED_OUT;
	  END IF;
  END IF;
  CLOSE transact_cursor;
  CLOSE payment_cursor;
EXCEPTION
  WHEN MAXING_OUT THEN
	RAISE_APPLICATION_ERROR(-20001,'Amount maxing out credit!');
  WHEN MAXED_OUT THEN
	RAISE_APPLICATION_ERROR(-20002,'No available credit limit!');
  WHEN NO_TRANSACTIONS THEN
	CLOSE transact_cursor;
  WHEN NO_PAYMENT THEN
	CLOSE payment_cursor;
END;


CREATE OR REPLACE TRIGGER STOLEN_CREDIT_CARD
  BEFORE INSERT ON ACTIVITY
    FOR EACH ROW
DECLARE
  CDSTATUS        	VARCHAR(9);
  STOLEN_CARD     	EXCEPTION;
  NO_ACTIVITIES		EXCEPTION;
  NO_CREDIT_CARD	EXCEPTION;
  CURSOR Dummy_cursor (cdno CREDIT_CARD.CD_NUMBER%TYPE) IS
    SELECT STATUS FROM CREDIT_CARD WHERE CD_NUMBER = cdno;
BEGIN
  OPEN Dummy_cursor (:NEW.CD_NUMBER);
  FETCH Dummy_cursor INTO CDSTATUS;
  IF (CDSTATUS = 'STOLEN') THEN
	RAISE STOLEN_CARD;
  ELSIF Dummy_cursor%FOUND THEN
    RAISE NO_CREDIT_CARD;
  END IF;
  CLOSE Dummy_cursor;
EXCEPTION
  WHEN STOLEN_CARD THEN
    CLOSE Dummy_cursor;
    dbms_output.put_line('STOLEN CARD! ALERT AUTHORITIES!');
  WHEN NO_CREDIT_CARD THEN
    CLOSE Dummy_cursor;
END;