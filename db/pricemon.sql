--delete from updates; delete from checks;
--delete from sections; delete from items; delete from info;
--drop table sections; drop table items; drop table updates; drop table checks; drop table info;

create table "sources" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"name" VARCHAR NOT NULL,
	"uri" VARCHAR,
	"user" VARCHAR,
	"pass" VARCHAR
);

create table "checks" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"time_start" INTEGER NOT NULL,
	"duration" INTEGER,
	"updates" INTEGER DEFAULT 0
);

create table "updates" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"id_src" INTEGER NOT NULL,
	"id_check" INTEGER NOT NULL,
	"id_message" VARCHAR NOT NULL,
	"file" VARCHAR NOT NULL,
	"time" INTEGER NOT NULL
);

create table "items" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"id_src" INTEGER NOT NULL,
	"id_section" INTEGER NOT NULL,
	"id_section_neo" INTEGER,
	"id_update" INTEGER NOT NULL,
	"id_shop" INTEGER NOT NULL,
	"id_brand" INTEGER,
	"art" VARCHAR DEFAULT '',
	"name" VARCHAR NOT NULL,
	"price" REAL,
	"price_diff" REAL,
	"warranty" INTEGER,
	"access" INTEGER DEFAULT 0,
	"is_new" INTEGER DEFAULT 0
);

create table "items_links" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"id_neo" VARCHAR DEFAULT '',
	"id_ntc" VARCHAR DEFAULT ''
);

create table "info" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"id_update" INTEGER NOT NULL,
	"id_item" INTEGER NOT NULL,
	"price" REAL
);

create table "meta_sections" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"name" VARCHAR UNIQUE,
	"items_child" INTEGER DEFAULT 0,
	"items_total" INTEGER DEFAULT 0,
	"items_last" INTEGER DEFAULT 0,
	"items_new" INTEGER DEFAULT 0,
	"order" INTEGER DEFAULT 0,
	"is_active" INTEGER DEFAULT 1,
	"sum_inc" FLOAT DEFAULT 0,
	"sum_dec" FLOAT DEFAULT 0
);

create table "sections" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"id_src" INTEGER NOT NULL,
	"id_meta" INTEGER,
	"id_brand" INTEGER,
	"id_update" INTEGER NOT NULL,
	"name" VARCHAR NOT NULL,
	"items_total" INTEGER DEFAULT 0,
	"items_last" INTEGER DEFAULT 0,
	"items_new" INTEGER DEFAULT 0,
	"order" INTEGER DEFAULT 0,
	"is_active" INTEGER DEFAULT 1,
	"sum_inc" FLOAT DEFAULT 0,
	"sum_dec" FLOAT DEFAULT 0
);

create table "brands" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"id_main" INTEGER,
	"name" VARCHAR UNIQUE,
	"description" VARCHAR
);

create table "attr_keys" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"name" VARCHAR UNIQUE
);
create table "attr_vals" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"name" VARCHAR UNIQUE
);
insert into attr_vals (id, name) values (0, '');

create table "items_attrs" (
	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	"id_item" INTEGER NOT NULL,
	"id_attr_key" INTEGER NOT NULL,
	"id_attr_val" INTEGER NOT NULL
);

create index updates_id_check    on updates ( id_check );
create index updates_id_src      on updates ( id_src );
create index updates_id_message  on updates ( id_message );
create index items_id_section    on items   ( id_section );
create index items_id_sectionneo on items   ( id_section_neo );
create index items_id_src        on items   ( id_src );
create index items_id_update     on items   ( id_update );
create index items_id_shop       on items   ( id_shop );
create index items_name          on items   ( name );
create index items_art           on items   ( art );
create index items_is_new        on items   ( is_new );
create index items_id_brand      on items   ( id_brand );
create index info_id_update      on info    ( id_update );
create index info_id_item        on info    ( id_item );
create index sections_id_meta    on sections( id_meta );
create index sections_id_update  on sections( id_update );
create index sections_id_brand   on sections( id_brand );
create index sections_id_src     on sections( id_src );
create index sections_name       on sections( name );
create index sections_is_active  on sections( is_active );
create index items_attrs_id_item     on items_attrs( id_item );
create index items_attrs_id_attr_key on items_attrs( id_attr_key );
create index items_attrs_id_attr_val on items_attrs( id_attr_val );
create index items_links_id_neo  on items_links( id_neo );
create index items_links_id_ntc  on items_links( id_ntc );
create index brands_id_main      on brands( id_main );

insert into "sources" values(1,'neologic', '{imap.pochta.ru/imap/ssl/novalidate-cert}INBOX.&BBAEQARFBDgEMg-.Neologic', 'darkpark@pisem.net', 'u9g785pkeb3x');
insert into "sources" values(2,'ntcom',    '{imap.pochta.ru/imap/ssl/novalidate-cert}INBOX.&BBAEQARFBDgEMg-.NTCom',    'darkpark@pisem.net', 'u9g785pkeb3x');

insert into brands (name) values('MicroStar');
insert into brands (name) values('Inno3D');
insert into brands (name) values('Force3D');
insert into brands (name) values('AVerMedia');
insert into brands (name) values('Creative');
insert into brands (name) values('LogicFox');
insert into brands (name) values('Foxconn');
insert into brands (name) values('Deluxe');
insert into brands (name) values('Mitsumi');
insert into brands (name) values('Perixx');
insert into brands (name) values('Labtec');
insert into brands (name) values('Thrustmaster');
insert into brands (name) values('Maxxtro');
insert into brands (name) values('Brother');
insert into brands (name) values('TrippLite');
insert into brands (name) values('APC');
insert into brands (name) values('FSP');
insert into brands (name) values('Mustek');
insert into brands (name) values('HP');
insert into brands (name) values('A4 Tech');
insert into brands (name) values('eCASE');
insert into brands (name) values('Minolta');
insert into brands (name) values('Pioneer');
insert into brands (name, id_main) values('Hewlett Packard', (select id from brands where lower(name) = 'hp'));
insert into brands (name, id_main) values('A4Tech', (select id from brands where lower(name) = 'a4 tech'));

--select s.name, b.name from sections s, brands b where s.id_brand = b.id
--select ms.name, s.name from sections s, meta_sections ms where s.id_meta = ms.id
--update sections set id_brand = (select ifnull(id_main, id) from (select * from brands order by length(name) desc) as brands where lower(sections.name) like '%' || lower(brands.name) || '%' limit 1)
--select sum(items_total) from sections 
--select count(*) from items where id_src=1

vacuum;
