# Attribute constraints
    - Album Rating ( overall rating ) cannot be NULL and must be an integer
    - Rating submission must be an integer (-1 for negative and 1 for positive)
    - Song Rating is a decimal, calculated using the number of positive and negative ratings submitted (number_positive / number_all)
    - Song Price cannot be NULL must be an positive integer between 0,10€ and 3,00€
    - Subscription Price cannot be NULL and must be an positive integer
    - Views cannot be NULL and must be an positive integer
    - Length cannot be NULL and must be an positive integer with a maximum value of 3000 seconds ( 50 minutes )
    - All Names cannot be NULL and must be a String containing only alphanumeric characters and 
      can be at most 30 characters long for a song, 20 characters long for a Genre,
      and 25 characters long for a User.
    - Usernames ( Login names ) cannot be NULL and can only contain alphanumeric characters with no symbols and 
      must be between 5 and 25 characters
    - Publishing Date cannot be NULL and must be in format dd/mm/yyyy
    - Downloads cannot be NULL and must be an positive integer
    - Timestamp must be a positive integer with a maximum value of the corresponding song 
      length minus 10 seconds ( our teaser length )
    - Profile description can have a maximum length of 500 for a listener and 1000 for a creator
    - Creator cannot be NULL
    - E-Mail cannot be NULL and must be a valid E-Mail
    - Password cannot be NULL and must be a String containing atleast one capitalt letter and a number and 
      having a length between 7 and 50 characters.
    - Billing Date cannot be NULL and must be in format dd/mm/yyyy
    
    ( everything except for Payment details cannot be NULL )
# Tuple constraints
    - Song needs to be uploaded by one or more Composer(s)
    - Album needs to have one or more songs in it
    - Song needs to belong to Genre
# Relation constraints
    - There cannot be two users with the same username
    - There cannot be two users with the same E-Mail
# Database constraints
    - Playlist Creator must be an existing user (Listener or Composer) on the platform.
    - Album Creator must be an existing Composer on the platform
