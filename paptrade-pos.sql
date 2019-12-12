CREATE TABLE USER_ (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	USERNAME varchar(50) not null,
	PASSWORD varchar(100) not null,
	LAST_NAME varchar(50) not null,
	FIRST_NAME varchar(50) not null,
	POSITION varchar(50) not null,
	CONTACT_NO varchar(50) not null,
	IMG blob,
	BRANCH_ID varchar(50) not null,
	ROLE varchar(50) not null,
	LAST_LOGIN_DT timestamp,
	STATUS varchar(20) not null,
	RETRY_CNT int(11) not null default 0,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50),
	UPDATED_DT timestamp null,
	CONSTRAINT USER_INVENTORY_ID_uk UNIQUE KEY (ID),
	CONSTRAINT USER_INVENTORY_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCH (ID)
);


CREATE TABLE SUPPLIERS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	SUPPLIER_NAME varchar(100) not null,
	CONTACT_PERSON varchar(100) not null,
	ADDRESS varchar(255) not null,
	CONTACT_NO varchar(50) not null,
	EMAIL varchar(50) not null,
	WEBSITE varchar(100) not null,
	NOTES varchar(255) null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT SUPPLIERS_ID_uk UNIQUE KEY (ID)
);

CREATE TABLE UNITS_OF_MEASURE (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	UNIT_OF_MEASURE varchar (50) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT UNITS_OF_MEASURE_ID_uk UNIQUE KEY (ID)
);

CREATE TABLE CATEGORIES (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	CATEGORY varchar (50) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT CATEGORIES_ID_uk UNIQUE KEY (ID)
);

CREATE TABLE BRANDS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRAND varchar (50) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT BRANDS_ID_uk UNIQUE KEY (ID)
);

CREATE TABLE MODELS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRAND varchar (50) not null,
	MODEL varchar (50) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT MODELS_ID_uk UNIQUE KEY (ID)
);