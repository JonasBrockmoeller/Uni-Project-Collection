drop schema public cascade;
create schema public;

 

CREATE TABLE if not exists Subscription(
    ID serial PRIMARY KEY,
    NAME varchar(25) NOT NULL,
    PRICE numeric(4,2) CHECK (PRICE >= 0)
);


CREATE TABLE if not exists Account(
    USERNAME varchar(25) PRIMARY KEY CHECK (char_length(USERNAME) >= 5),
    SUBSCRIPTION_ID serial,
    PASSWORD varchar(70) NOT NULL CHECK (char_length(PASSWORD) >= 7),
    EMAIL varchar(50) NOT NULL,
    PAYMENT_DETAILS varchar(50),
    DISPLAY_NAME varchar(25) NOT NULL,
    DESCRIPTION varchar(1000),
    LAST_BILLING_DAY smallint CHECK(LAST_BILLING_DAY IS NOT NULL AND LAST_BILLING_DAY BETWEEN 0 and 31),
    FOREIGN KEY(subscription_id) REFERENCES Subscription(ID)
);

 

CREATE TABLE if not exists Genre(
    ID serial PRIMARY KEY,
    NAME varchar(20) NOT NULL
);

 

CREATE TABLE if not exists Song(
    ID serial PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    CREATOR_USERNAME varchar(25),
    GENRE_ID serial,
    NAME varchar(50) NOT NULL,
    LENGTH smallint CHECK (LENGTH IS NOT NULL AND LENGTH BETWEEN 30 AND 3000),
    LISTENING_PRICE numeric(4,2) CHECK (LISTENING_PRICE IS NOT NULL AND LISTENING_PRICE >= 0),
    DOWNLOAD_PRICE numeric(4,2) CHECK (DOWNLOAD_PRICE IS NOT NULL AND DOWNLOAD_PRICE >= 0),
    PREVIEW_TIMESTAMP smallint CHECK (PREVIEW_TIMESTAMP IS NOT NULL AND PREVIEW_TIMESTAMP BETWEEN 0 AND (LENGTH-10)),
    NR_VIEWS int CHECK (NR_VIEWS IS NOT NULL AND NR_VIEWS >= 0),
    NR_DOWNLOADS int CHECK (NR_DOWNLOADS IS NOT NULL AND NR_DOWNLOADS >= 0),
    PUBLISHING_DATE date NOT null,
    FOREIGN KEY(Genre_id) REFERENCES Genre(ID),
    FOREIGN KEY(creator_username) REFERENCES Account(Username)
);


 


CREATE TABLE if not exists AlbumPlaylist(
    ID serial PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    CREATOR_USERNAME varchar(25),
    NAME varchar(45) NOT NULL,
    DESCRIPTION varchar(100),
    IsPublic boolean NOT NULL,
    IsAlbum boolean NOT NULL,
    PUBLISHING_DATE date NOT null,
    FOREIGN KEY(creator_username) REFERENCES Account(USERNAME)
);

 

CREATE TABLE if not exists USER_SONG(
    USERNAME varchar(25),
    SONG_ID serial,
    AMOUNT_OF_TIMES_PLAYED smallint CHECK (AMOUNT_OF_TIMES_PLAYED IS NOT NULL AND AMOUNT_OF_TIMES_PLAYED>=0),
    RATING smallint DEFAULT 0 CHECK (RATING IS NOT NULL AND RATING BETWEEN -1 AND 1),
    PRIMARY KEY(USERNAME, SONG_ID),
    FOREIGN KEY(username) REFERENCES Account(USERNAME),
    FOREIGN KEY(song_id) REFERENCES Song(ID)
);

 

create table if not exists USER_LISTENED_TO_SONG (
    USERNAME varchar(25),
    SONG_ID serial,
    DATE_TIME timestamp not null,
    PRIMARY KEY(USERNAME, SONG_ID),
    FOREIGN KEY(username) REFERENCES Account(USERNAME),
    FOREIGN KEY(song_id) REFERENCES Song(ID)
);

 

CREATE TABLE if not exists ALBUM_PLAYLIST_SONGS(
    ALBUM_PLAYLIST_ID serial,
    SONG_ID serial,
    PRIMARY KEY(ALBUM_PLAYLIST_ID, SONG_ID),
    FOREIGN KEY(album_playlist_ID) REFERENCES AlbumPlaylist(ID),
    FOREIGN KEY(song_id) REFERENCES Song(ID)
);

create table if not exists Payments(
	ACCOUNT_USERNAME varchar(70),
	CARDNUMBER varchar(70),
    CARDHOLDER varchar(70),
    EXMONTH varchar(70),
    EXYEAR varchar(70),
    CVV varchar(70),
    FOREIGN KEY(ACCOUNT_USERNAME) REFERENCES Account(username),
    PRIMARY KEY(ACCOUNT_USERNAME)
);

--genres--
INSERT INTO genre (ID,NAME) 
VALUES (1, 'Rock');
INSERT INTO genre (ID,NAME) 
VALUES (2, 'Pop');
INSERT INTO genre (ID,NAME) 
VALUES (3, 'EDM');
INSERT INTO genre (ID,NAME) 
VALUES (4, 'Hip-Hop');
INSERT INTO genre (ID,NAME) 
VALUES (5, 'R&B');
INSERT INTO genre (ID,NAME) 
VALUES (6, 'Latin');
INSERT INTO genre (ID,NAME) 
VALUES (7, 'Country');
INSERT INTO genre (ID,NAME) 
VALUES (8, 'House');
INSERT INTO genre (ID,NAME) 
VALUES (9, 'Christmas');
INSERT INTO genre (ID,NAME) 
VALUES (10, 'Hard rock');
INSERT INTO genre (ID,NAME) 
VALUES (11, 'Lounge');
INSERT INTO genre (ID,NAME) 
VALUES (12, 'Electronic');
INSERT INTO genre (ID,NAME) 
VALUES (13, 'Metal');
INSERT INTO genre (ID,NAME) 
VALUES (14, 'Folk');
INSERT INTO genre (ID,NAME) 
VALUES (15, 'Pop-folk');
INSERT INTO genre (ID,NAME) 
VALUES (16, 'Christian');
INSERT INTO genre (ID,NAME) 
VALUES (17, 'Disco');
INSERT INTO genre (ID,NAME) 
VALUES (18, 'Soul');
INSERT INTO genre (ID,NAME) 
VALUES (19, 'Funk');
INSERT INTO genre (ID,NAME) 
VALUES (20, 'Jazz');
INSERT INTO genre (ID,NAME) 
VALUES (21, 'Classical');
INSERT INTO genre (ID,NAME) 
VALUES (22, 'Ska');
INSERT INTO genre (ID,NAME) 
VALUES (23, 'Reggae');


--subs--
INSERT INTO subscription (ID,NAME,price) 
VALUES (1, 'moderator', 0);
INSERT INTO subscription (ID,NAME,price) 
VALUES (2, 'listener', 9.99);
INSERT INTO subscription (ID,NAME,price) 
VALUES (3, 'premium_listener', 14.99);
INSERT INTO subscription (ID,NAME,price) 
VALUES (4, 'creator', 29.99);


--accounts--
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('post-malone', 4, MD5('pword123'), 'post@malone.com', 'verified', 'POST MALONE', 'YOYOYO', 26);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('bslavov', 1, MD5('BorisLovesYogurt'), 'boris-slavov@gmail.com', 'verified', 'BORIS', 'Hey there, I?m using Songify', 1);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('teddy', 2, MD5('GreenHouse2015'), 'Ted.Johnsson@icloud.com', 'verified', 'TEDDY', 'Hey there, I?m using Songify', 7);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('Dave25', 3, MD5('Fortnite2020!'), 'dave@student.tub.com', 'verified', 'David', 'Hey there, I?m using Songify', 19);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('L-B-26', 3, MD5('Huntsville1987'), 'L-Bock@gmail.com', 'verified', 'Lindsey Bock', 'Hey there, I?m using Songify', 3);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('UK-Jake', 4, MD5('Jake_is_the_MVP!!!'), 'Jake-not-Gyllenhaal@gmail.com', 'verified', 'Jake Gyllenhaal 2.0', 'Hey there, I?m using Songify', 29);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('justin_b', 4, MD5('jword123'), 'jb@wtf.com', 'verified', 'Justin Bieber', 'J life is Gay life', 23);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('bob_marley', 4, MD5('bword123'), 'bob_420blazeit@mail.com', 'verified', 'Bob Marley', 'Yu kno how we do it ;)', 12);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('kamelia_official', 4, MD5('kword123'), 'kamelia@abv.com', 'verified', 'Kamelia', 'Crazy about you', 21);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('beethoven_ftw', 4, MD5('beword123'), 'classical_bee@class.com', 'verified', 'Beethoven', 'Real music for real fans', 10);
INSERT INTO account (username, subscription_id, password , email, payment_details, display_name, description, last_billing_day) 
VALUES ('abba_official', 4, MD5('aword123'), 'abba@official.com', 'verified', 'ABBA', 'Dancing all day all night', 28);


--songs--
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(100, 'justin_b', 2, 'Baby', 158, 1.2, 1.5, 111, 7121, 911, '2010-Jan-28');
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(101, 'justin_b', 19, 'Sorry', 258, 1.5, 2.5, 211, 42221, 3121, '2016-Jan-28');
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(102, 'justin_b', 6, 'Despacito', 312, 2.2, 2.8, 45, 23341, 5211, '2018-Jan-28');

insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(103, 'bob_marley', 22, 'I shot the sheriff', 212, 1.2, 1.5, 32, 65112, 571, '2003-May-18');
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(104, 'bob_marley', 18, 'One love', 252, 2.2, 2.5, 50, 8712, 491, '2005-Mar-08');
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(105, 'bob_marley', 22, 'Dont worry be happy', 312, 1.7, 2.5, 68, 420420, 4200, '2004-Dec-08');

insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(106, 'kamelia_official', 15, 'Luda po tebe', 240, 1.2, 1.5, 11, 2112, 123, '1999-Dec-23');
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(107, 'kamelia_official', 15, 'Napipai go', 250, 1.0, 1.1, 21, 4112, 350, '1995-Nov-23');
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(108, 'kamelia_official', 14, '4-4-2', 190, 1.3, 1.7, 31, 1312, 442, '1994-Oct-23');

insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(109, 'beethoven_ftw', 4, 'Symphony No.3 In E Flat, Op.55  Eroica', 400, 1.4, 2.5, 30, 1700, 789, '1804-Dec-23');
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(110, 'beethoven_ftw', 4, 'Symphony No. 9  Choral', 300, 1.5, 2.1, 40, 3400, 1432, '1809-Apr-25');
insert into "song" (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date)
 values(111, 'beethoven_ftw', 4, 'Piano Sonata No.30 In E, Op.109', 320, 1.7, 2.0, 30, 10200, 1234, '1806-Mar-13');

INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (201, 'abba_official', 17, 'Dancing Queen', 232, 0.25, 2.00, 114, 1324687, 204239, '1975-08-04');
INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (202, 'abba_official', 17, 'Take a chance on me', 245, 0.25, 2.00, 95, 997324, 197634, '1978-01-06');
INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (203, 'abba_official', 17, 'Take a chance on me', 288, 0.25, 2.00, 140, 508328, 69324, '1979-05-13');

INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (1, 'post-malone', 3, 'Circles', 226, 0.99, 1.49, 74, 783869, 32365, '2020-01-01');
INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (2, 'post-malone', 4, 'Sunflower', 218, 0.69, 1.99, 39, 115659, 40342, '2018-10-18');
INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (3, 'post-malone', 5, 'Goodbyes', 182, 0.49, 1.00, 44, 320597, 102764, '2019-07-24');

INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (4, 'UK-Jake', 7, 'home', 253, 0.09, 1.00, 198, 11, 2, '2017-03-21');
INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (5, 'UK-Jake', 17, 'home party remix', 403, 0.19, 2.50, 198, 53, 22, '2017-05-07');
INSERT INTO song (id, creator_username, genre_id, name, length, listening_price, download_price, preview_timestamp, nr_views, nr_downloads, publishing_date) 
VALUES (6, 'UK-Jake', 9, 'It?s christmas', 201, 0.15, 2.00, 32, 51, 9, '2018-11-01');


--albums--
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (1,'abba_official','Greatest Hits of ABBA','The greatest collection of ABBAs hits',true,true,'1975-08-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (2,'post-malone','Hollywoods Bleeding','Third studio album by American rapper and singer Post Malone.',true,true,'2019-08-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (3,'bob_marley','One Love',' The Very Best of Bob Marley & The Wailers',true,true,'2001-08-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (4,'beethoven_ftw','Works of Beethoven','The greatest collection of Beethovens works',true,true,'1875-08-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (5,'justin_b','The Best','The Best is the first greatest hits album by Canadian singer Justin Bieber.',true,true,'2020-01-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (6,'UK-Jake','music vol.1','Yo guys my first album wow',true,true,'2018-08-04');


--playlists--
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (11,'UK-Jake','the reggae i like','here are my favourite jamaican hits',true,false,'2015-08-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (12,'post-malone','chill-vibes','Yo chill yo',true,false,'2019-12-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (13,'UK-Jake','feeling classy','I love classical music - check it out',true,false,'2011-08-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (14,'UK-Jake','Disco party','Disco Disco Disco',true,false,'2018-08-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (15,'UK-Jake','The Best Pop','Pop can make me wanna drink',true,false,'2017-01-04');
INSERT INTO albumplaylist (id,creator_username,name,description,ispublic,isalbum,publishing_date) 
VALUES (16,'UK-Jake','trap n rap','for the tough guys yo',true,false,'2019-08-04');
				      
--songs in albums--				      
insert into album_playlist_songs (album_playlist_id, song_id) values (1, 12);
insert into album_playlist_songs (album_playlist_id, song_id) values (1, 13);
insert into album_playlist_songs (album_playlist_id, song_id) values (1, 14);
