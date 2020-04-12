CREATE TABLE BRANCHES (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRANCH_NAME varchar(100) not null,
	ADDRESS varchar(255) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50),
	UPDATED_DT timestamp null,
	CONSTRAINT BRANCHES_ID_uk UNIQUE KEY (ID)
);


CREATE TABLE USERS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	USERNAME varchar(50) not null,
	PASSWORD varchar(100) not null,
	STATUS varchar(20) not null,
	RETRY_CNT int(11) not null default 0,
	LAST_LOGIN_DT timestamp null,
	ROLE varchar(50) not null,
	BRANCH_ID varchar(50) not null,
	LAST_NAME varchar(50) not null,
	FIRST_NAME varchar(50) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50),
	UPDATED_DT timestamp null,
	CONSTRAINT USERS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT USERS_USERNAME_uk UNIQUE KEY (USERNAME),
	CONSTRAINT USERS_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCHES (ID)
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
	CONSTRAINT BRANDS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT BRANDS_BRAND_uk UNIQUE KEY (BRAND)
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
	CONSTRAINT CATEGORIES_ID_uk UNIQUE KEY (ID),
	CONSTRAINT CATEGORIES_CATEGORY_uk UNIQUE KEY (CATEGORY)
);


CREATE TABLE STOCK_TYPES (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	STOCK_TYPE varchar(50) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT STOCK_TYPES_ID_uk UNIQUE KEY (ID),
	CONSTRAINT STOCK_TYPES_STOCK_TYPE_uk UNIQUE KEY (STOCK_TYPE)
);


CREATE TABLE ITEMS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRAND_ID varchar (50) not null,
	DSCP varchar (50) not null,
	CATEGORY_ID varchar (50) not null,
	PRICE decimal(10,2) not null,
	CRITICAL_QTY int(11) not null,
	STOCK_TYPE_ID varchar(50) not null,
	STOCK_TYPE_CONTENT int(11) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT ITEMS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT ITEMS_BRAND_ID_DSCP_uk UNIQUE KEY (BRAND_ID, DSCP),
	CONSTRAINT ITEMS_BRAND_ID_fk FOREIGN KEY (BRAND_ID) REFERENCES BRANDS (ID),
	CONSTRAINT ITEMS_CATEGORY_ID_fk FOREIGN KEY (CATEGORY_ID) REFERENCES CATEGORIES (ID),
	CONSTRAINT ITEMS_STOCK_TYPE_ID_fk FOREIGN KEY (STOCK_TYPE_ID) REFERENCES STOCK_TYPES (ID)
);


CREATE TABLE WAREHOUSE_INVENTORY (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	ITEM_ID varchar(50) not null,
	CURRENT_QTY int(11) not null,
	AVAILABLE_QTY int(11) not null,
	CRITICAL_QTY int(11) not null,
	CONSTRAINT WAREHOUSE_INVENTORY_ID_uk UNIQUE KEY (ID),
	CONSTRAINT WAREHOUSE_INVENTORY_ITEM_ID_uk UNIQUE KEY (ITEM_ID),
	CONSTRAINT WAREHOUSE_INVENTORY_ITEM_ID_fk FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ID)
);


CREATE TABLE WAREHOUSE_INVENTORY_HIST (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	INVENTORY_ID varchar(50) not null,
	ITEM varchar(255) not null,
	QTY int(11) not null,
	QTY_RUNNING int(11) not null,
	MOVEMENT varchar(10) not null,
	UPDATED_BY varchar(50) not null,
	UPDATED_DT timestamp not null default current_timestamp(),
	REMARKS varchar(100) null,
	CONSTRAINT WAREHOUSE_INVENTORY_HIST_ID_uk UNIQUE KEY (ID),
	CONSTRAINT WAREHOUSE_INVENTORY_HIST_INVENTORY_ID_fk FOREIGN KEY (INVENTORY_ID) REFERENCES WAREHOUSE_INVENTORY (ID)
);


CREATE TABLE BRANCH_INVENTORY (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRANCH_ID varchar (50) not null,
	ITEM_ID varchar(50) not null,
	QTY int(11) not null,
	CRITICAL_QTY int(11) not null,
	CONSTRAINT BRANCH_INVENTORY_ID_uk UNIQUE KEY (ID),
	CONSTRAINT BRANCH_INVENTORY_BRANCH_ID_ITEM_ID_uk UNIQUE KEY (BRANCH_ID, ITEM_ID),
	CONSTRAINT BRANCH_INVENTORY_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCHES (ID),
	CONSTRAINT BRANCH_INVENTORY_ITEM_ID_fk FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ID)
);


CREATE TABLE BRANCH_INVENTORY_HIST (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRANCH_ID varchar (50) not null,
	INVENTORY_ID varchar(50) not null,
	ITEM varchar(255) not null,
	QTY int(11) not null,
	QTY_RUNNING int(11) not null,
	MOVEMENT varchar(10) not null,
	UPDATED_BY varchar(50) not null,
	UPDATED_DT timestamp not null default current_timestamp(),
	REMARKS varchar(100) null,
	CONSTRAINT BRANCH_INVENTORY_HIST_ID_uk UNIQUE KEY (ID),
	CONSTRAINT BRANCH_INVENTORY_HIST_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCHES (ID),
	CONSTRAINT BRANCH_INVENTORY_HIST_INVENTORY_ID_fk FOREIGN KEY (INVENTORY_ID) REFERENCES BRANCH_INVENTORY (ID)
);


CREATE TABLE SUPPLY_REQUESTS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	ITEM_ID varchar(50) not null,
	QTY int(11) not null,
	BRANCH_ID varchar (50) not null,
	REQUESTED_BY varchar(50) not null,
	REQUESTED_DT timestamp not null default current_timestamp(),
	STATUS varchar(20) not null,
	PROCESSED_BY varchar(50) null,
	PROCESSED_DT timestamp null,
	APPROVED_QTY int(11) null,
	RECEIVED_BY varchar(50) null,
	RECEIVED_DT timestamp null,
	CONSTRAINT SUPPLY_REQUESTS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SUPPLY_REQUESTS_ITEM_ID_fk FOREIGN KEY (ITEM_ID) REFERENCES ITEMS (ID),
	CONSTRAINT SUPPLY_REQUESTS_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCHES (ID)
);


CREATE TABLE SALES (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRANCH_ID varchar (50) not null,
	REF_NO varchar (50) not null,
	GRAND_TOTAL decimal(18,2) not null,
	PAYMENT decimal(18,2) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	CONSTRAINT SALES_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SALES_REF_NO_uk UNIQUE KEY (REF_NO),
	CONSTRAINT SALES_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCHES (ID)
);


CREATE TABLE SALES_DTLS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	SALES_ID varchar (50) not null,
	BRANCH_INVENTORY_ID varchar (50) not null,
	UNIT_PRICE decimal(18,2) not null,
	QUANTITY int(11) not null,
	CONSTRAINT SALES_DTLS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SALES_DTLS_SALES_ID_fk FOREIGN KEY (SALES_ID) REFERENCES SALES (ID),
	CONSTRAINT SALES_DTLS_BRANCH_INVENTORY_ID_fk FOREIGN KEY (BRANCH_INVENTORY_ID) REFERENCES BRANCH_INVENTORY (ID)
);



CREATE TABLE SALES_TEMP (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRANCH_ID varchar (50) not null,
	CUST_NAME varchar (50) not null,
	ITEM_CNT int(11) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	CONSTRAINT SALES_TEMP_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SALES_TEMP_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCHES (ID)
);


CREATE TABLE SALES_TEMP_DTLS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	SALES_TEMP_ID varchar (50) not null,
	BRANCH_INVENTORY_ID varchar (50) not null,
	QUANTITY int(11) not null,
	CONSTRAINT SALES_TEMP_DTLS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SALES_TEMP_DTLS_SALES_TEMP_ID_fk FOREIGN KEY (SALES_TEMP_ID) REFERENCES SALES_TEMP (ID),
	CONSTRAINT SALES_TEMP_DTLS_BRANCH_INVENTORY_ID_fk FOREIGN KEY (BRANCH_INVENTORY_ID) REFERENCES BRANCH_INVENTORY (ID)
);



INSERT INTO `branches` (`ID`, `VERSION`, `DEL`, `BRANCH_NAME`, `ADDRESS`, `CREATED_BY`, `CREATED_DT`, `UPDATED_BY`, `UPDATED_DT`) VALUES ('init_branch',0,false,'INITIAL BRANCH','INITIAL BRANCH ADDRESS','INITIAL_USER','2020-03-29',null,null)
INSERT INTO `users` (`ID`, `VERSION`, `DEL`, `USERNAME`, `PASSWORD`, `STATUS`, `RETRY_CNT`, `LAST_LOGIN_DT`, `ROLE`, `BRANCH_ID`, `LAST_NAME`, `FIRST_NAME`, `CREATED_BY`, `CREATED_DT`) VALUES ('init_user',0,false,'INITUSER','$2y$10$8vKsIWEeyMQOzDvBWJ2wneN6BS4s1VTav7v4kof7jiFwmDhOBI8aq','ACTIVE',0,null,'SYS_ADMIN','init_branch','USER','INITIAL','DEFAULT','2020-03-29')
