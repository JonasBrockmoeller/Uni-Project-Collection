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

create table if not exists Payments(
	ACCOUNT_USERNAME varchar(70),
	CARDNUMBER varchar(70),
    CARDHOLDER varchar(70),
    EXMONTH varchar(70),
    EXYEAR varchar(70),
    CVV varchar(70),
    CREDIT numeric default 0,
    FOREIGN KEY(ACCOUNT_USERNAME) REFERENCES Account(username),
    PRIMARY KEY(ACCOUNT_USERNAME)
);



CREATE TABLE if not exists Genre(
    ID serial PRIMARY KEY,
    NAME varchar(20) NOT NULL
);

 

CREATE TABLE if not exists Song(
    ID bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    CREATOR_USERNAME varchar(25),
    GENRE_ID serial,
    NAME varchar(50) NOT NULL,
    LENGTH smallint CHECK (LENGTH IS NOT NULL AND LENGTH BETWEEN 30 AND 3000),
    LISTENING_PRICE numeric(4,2) CHECK (LISTENING_PRICE IS NOT NULL AND LISTENING_PRICE >= 0),
    DOWNLOAD_PRICE numeric(4,2) CHECK (DOWNLOAD_PRICE IS NOT NULL AND DOWNLOAD_PRICE >= 0),
    PREVIEW_TIMESTAMP smallint CHECK (PREVIEW_TIMESTAMP IS NOT NULL AND PREVIEW_TIMESTAMP BETWEEN 0 AND (LENGTH-10)),
    PUBLISHING_DATE date NOT null,
    FOREIGN KEY(Genre_id) REFERENCES Genre(ID),
    FOREIGN KEY(creator_username) REFERENCES Account(Username)
);


 


CREATE TABLE if not exists AlbumPlaylist(
    ID bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
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
    IS_DOWNLOADED boolean DEFAULT false,
    RATING smallint DEFAULT 0 CHECK (RATING IS NOT NULL AND RATING BETWEEN -1 AND 1),
    PRIMARY KEY(USERNAME, SONG_ID),
    FOREIGN KEY(username) REFERENCES Account(USERNAME),
    FOREIGN KEY(song_id) REFERENCES Song(ID)
);

 

create table if not exists USER_LISTENED_TO_SONG (
    USERNAME varchar(25),
    SONG_ID serial,
    DATE_TIME timestamp not null,
    PRIMARY KEY(USERNAME, SONG_ID, DATE_TIME),
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
VALUES (0, 'inactive user', 0);
INSERT INTO subscription (ID,NAME,price) 
VALUES (1, 'moderator', 0);
INSERT INTO subscription (ID,NAME,price) 
VALUES (2, 'listener', 9.99);
INSERT INTO subscription (ID,NAME,price) 
VALUES (3, 'premium_listener', 14.99);
INSERT INTO subscription (ID,NAME,price) 
VALUES (4, 'creator', 29.99);


create function deduct_credit (price payments.credit%type, username payments.account_username%type)
RETURNS boolean AS $$
declare
curcredit numeric;
begin
select credit into curcredit from payments where account_username=username;
if(curcredit<price) then
raise exception 'Not enough credit!';return false;
else
update payments SET credit=credit-price where account_username=username;return true;
end if;
end; $$ language plpgsql;
