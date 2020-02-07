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

CREATE TABLE UNIT_TYPES (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	UNIT_TYPE varchar (50) not null,
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
	BRAND_ID varchar (50) not null,
	MODEL varchar (50) not null,
	CATEGORY_ID varchar (50) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT MODELS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT MODELS_BRAND_ID_fk FOREIGN KEY (BRAND_ID) REFERENCES BRANDS (ID),
	CONSTRAINT MODELS_CATEGORY_ID_fk FOREIGN KEY (CATEGORY_ID) REFERENCES CATEGORIES (ID)
);

CREATE TABLE INVENTORIES (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	SKU varchar (50) not null,
	ITEM_ID varchar (50) not null,
	DSCP varchar (50) not null,
	UNIT_TYPE varchar (50) not null,
	QUANTITY int(11) not null,
	BUYING_PRICE decimal(18,2) not null,
	SELLING_PRICE decimal(18,2) not null,
	PO_REF_NO varchar (50) null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT INVENTORIES_ID_uk UNIQUE KEY (ID),
	CONSTRAINT INVENTORIES_ITEM_ID_fk FOREIGN KEY (ITEM_ID) REFERENCES MODELS (ID)
);

CREATE TABLE INVENTORIES_BRANCH (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRANCH_ID varchar (50) not null,
	INVENTORY_ID varchar (50) not null,
	ITEM_ID varchar (50) not null,
	QUANTITY int(11) not null,
	SELLING_PRICE decimal(18,2) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT INVENTORIES_BRANCH_ID_uk UNIQUE KEY (ID)
);

CREATE TABLE PURCHASE_ORDERS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	REF_NO varchar(50) not null,
	STATUS varchar(10) not null,
	ORDERED_DT datetime not null,
	EXPECTED_DT datetime not null,
	ORDERED_BY varchar(50) not null,
	SUPPLIER_ID varchar(50) not null,
	NOTES varchar(255) null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	UPDATED_BY varchar(50) null,
	UPDATED_DT timestamp null,
	CONSTRAINT PURCHASE_ORDERS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT PURCHASE_ORDERS_SUPPLIER_ID_fk FOREIGN KEY (SUPPLIER_ID) REFERENCES SUPPLIERS (ID)
);

CREATE TABLE PURCHASE_ORDERS_DTL (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	PURCHASE_ORDER_ID varchar(50) not null,
	MODEL_ID varchar(50) not null,
	QUANTITY int(11) not null,
	UNIT_PRICE decimal(18,2) not null,
	CONSTRAINT PURCHASE_ORDERS_DTL_ID_uk UNIQUE KEY (ID),
	CONSTRAINT PURCHASE_ORDERS_DTL_PURCHASE_ORDER_ID_fk FOREIGN KEY (PURCHASE_ORDER_ID) REFERENCES PURCHASE_ORDERS (ID),
	CONSTRAINT PURCHASE_ORDERS_DTL_MODEL_ID_fk FOREIGN KEY (MODEL_ID) REFERENCES MODELS (ID)
);


CREATE TABLE SALES (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRANCH_ID varchar (50) not null,
	REF_NO varchar (50) not null,
	GRAND_TOTAL decimal(18,2) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	CONSTRAINT SALES_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SALES_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCH (ID)
);


CREATE TABLE SALES_DTLS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	SALES_ID varchar (50) not null,
	INVENTORIES_BRANCH_ID varchar (50) not null,
	UNIT_PRICE decimal(18,2) not null,
	QUANTITY int(11) not null,
	CONSTRAINT SALES_DTLS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SALES_DTLS_SALES_ID_fk FOREIGN KEY (SALES_ID) REFERENCES SALES (ID),
	CONSTRAINT SALES_DTLS_INV_BRANCH_ID_fk FOREIGN KEY (INVENTORIES_BRANCH_ID) REFERENCES INVENTORIES_BRANCH (ID)
);


CREATE TABLE SALES_ON_HOLD (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	BRANCH_ID varchar (50) not null,
	CUST_NAME varchar (50) not null,
	GRAND_TOTAL decimal(18,2) not null,
	CREATED_BY varchar(50) not null,
	CREATED_DT timestamp not null default current_timestamp(),
	CONSTRAINT SALES_ON_HOLD_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SALES_ON_HOLD_BRANCH_ID_fk FOREIGN KEY (BRANCH_ID) REFERENCES BRANCH (ID)
);


CREATE TABLE SALES_ON_HOLD_DTLS (
	ID varchar(50) not null,
	VERSION int(11) not null default 0,
	DEL boolean not null default false,
	SALES_ON_HOLD_ID varchar (50) not null,
	INVENTORY_ID varchar (50) not null,
	ITEM_NAME varchar (50) not null,
	UNIT_PRICE decimal(18,2) not null,
	QUANTITY int(11) not null,
	SUB_TOTAL decimal(18,2) not null,
	CONSTRAINT SALES_ON_HOLD_DTLS_ID_uk UNIQUE KEY (ID),
	CONSTRAINT SALES_ON_HOLD_DTLS_SALES_ON_HOLD_ID_fk FOREIGN KEY (SALES_ON_HOLD_ID) REFERENCES SALES_ON_HOLD (ID)
);