# Data dictionary

•	**Song** = A major entity that can be bought/purchased in a digital version (.mp3) by premium/registered users. **A song can be 50 minutes long at most and 15 seconds minimum. Name can have 50 characters at most. The following is configurable later on, as 
our decision on upload size for composers is based on multiple factors. But for now we want the following to be the case: Since we want to be storage-efficient regarding the songs, but we also don't want to have songs of very low quality, we will use moderate levels of compression for the songs with mp3 format.**

• **Genre** = A style of music that involves a particular set of characteristics (i.e Jazz, rock, pop etc.). **Name has to be no longer than 50 letters**

•	**Publisher/Artist/Composer** = The person (or people) who has/ who have composed a song. **Name has to be no longer than 100 letters**

•	**Publishing Date** = The date on which a song was uploaded to Songify. **Date format is yyyy-mm-dd**

•	**Playlist/Album** = A list of songs that was put together by either a registered user(playlist) or a composer(album). 
                    The list can be used to listen to all of these songs one by one. **Playlist names can have 75 characters at most.**
                    
•	**Teaser** = A shortened version/preview of a song in the mp3 format. **The teaser can be at most 10 seconds long.**

•	**Recommendation** = A suggestion from the system for the user which song to listen to, **based on that user’s previous song history.**

•	**Statistics** = A section of the profile where a composer can check information regarding the songs and account
                **(e.g number of listens, number of downloads, etc.).**
                
•	**Review/Rating** = A public assessment of the song by a user. **A review can only be positive or negative(like/dislike)**

•	**Account** = A formal business arrangement providing for regular dealings or services **(such as reviewing, searching, or purchasing)**
            and involving the establishment and maintenance (profile) of said account. **There are three types of accounts: 
            listener accounts, moderator accounts and composer accounts.**
            
•	**Profile** = A  screen or series of screens that present the collection of profile information and content of a certain user. 
            This information can be changed by the user himself. **Profile description has to be 1000 characters at maximum**
                        
•	**Uploads** = Songs/albums that have been uploaded / added
            by a composer throughout the existence of their account. **No constraints.**
            
•	**Revenue** = The income generated as a result of users purchasing songs. **No constraints.**

•	**Payment options**  = The methods by which a user can purchase a song **(e.g bank account, Paypal, etc.)** and also adjust where the generated revenu is sent.

•	**Password**  = A string of characters that, once entered, allow the user to access their songify account. **Password must contain a capital letter along with a number, and must have at least 7 characters. Maximum amount of characters is 50.**

•	**Username**  = A string of characters that’s used as an identification by a person with access to their songify account. This can be based on someone’s actual name, or a nickname. **Usernames may have letters-only, or a comibation, or numbers-only. Minimum amount of characters is 5 and maximum amount of characters is 25. Usernames must be unique, so if a username already exists in the database the new user may not use that username.**

• **Profile picture** = An image that represents the account of a user. **The following is configurable later on, as 
our decision on file/upload size is based on multiple factors. But for now we want the following: Since we want to be storage-efficient regarding the images, but we also don't want to have images
of very low quality, we will use moderate levels of compression for the images with JPEG format.**

• **Song image** = An image related to a song that's assigned to said song. **The following is configurable later on, as 
our decision on file/upload size is based on multiple factors. But for now we want the following: Since we want to be storage-efficient regarding the images, but we also don't want to have images
of very low quality, we will use moderate levels of compression for the images with JPEG format.**

•	**Album information** = This is the data you get when you click on the "see album info" button. **This information includes: album title(maximum 25 characters), year the album was created, composer/author name and description(maximum 75 characters).**

•	**Playlist information** = This is the data you get when you click on the "see playlist info" button. **This information consists of just a description.**

•	**Downloads** = A collection of songs which are paid for and downloaded by the user. They are available to him for offline listening. **The downloaded file will be in the same format as it was uploaded to Songify.**

•	**Share a song** = Sharing a song means generating a link which a user can use to navigate to a specific song.

•	**Subscription** = This is the license which a user pays for and which allows him to use the application. **A subscription has a price(positive integer) and a validness period(at least one month). On top of that, there are different types of subscriptions, with different prices. (NEED TO SPECIFY THIS FURTHER)**

•	**Display name** = The name of an individual that is visible to other users on the platform (not username). **Alpha numeric characters-only + minimum characters = 3, maximum characters = 25**
