# About the Project
 [@RateMateBot](https://t.me/RateMateBot/) - is a Telegram Bot and related Telegram Mini App which allow users to rate existed channels, channels and bots and leave public or anonymous reviews, while the Mini App shows the average rating and all community reviews.

![RateMateBot Screenshot](https://imageupload.io/ib/tbE8yeU9W9ciN77_1696966584.png)

### Demo
Telegram Bot - https://t.me/RateMateBot/

### How to use it
1. Update your Telegram App up to the latest version 
2. Send a message to [@RateMateBot](https://t.me/RateMateBot/) to get a Rate Link (optional step as you may take Rate Link from step 2, it's always the same)
3. Publish the https://t.me/RateMateBot/rate (Rate Link) in the channel, group chat, supergroup chat or your chat with any bot (Rate Object). 
4. Click on the link (while it's published inside Rate Object)
5. Telegram where you will be able to rate this chat and see community reviews

##### General Notes
- No need in any settings: just publish the link and everybody will be able to rate this Telegram chat
- You can try to publish Rate Link in event a private chat (1-on-1 chat with any person), but Mini App is not available for rating people. Yet.

##### For Channel Admins
- Nobody will be able to rate your channel until you will publish the Rate Link yourself as a channel post.
- But if you have channel comments enabled (supergroup chat attached to your channel) anyone will be able to publish this link in the comments and rate it. But in ths case the reviews are related to the supergroup chat itself, not a channel.

### Used Technologies
This Telegram MiniApp uses Symfony 6.3 PHP Framework for quick and scalable backend API and Vue 3 JS Framework for reactive and smooth Frontend user experience. 

Read the [Step by step Development Guide](https://smqn.notion.site/Step-by-step-Development-Guide-of-RateMate-Telegram-Bot-faf23f9e326e4c98b7e49eabb6141c53?pvs=4) to learn more why this technologies were chosen and how to use them for quick creation of Telegram MiniApps of ANY type. For example current application has been created from scratch within 4 days only.

### Open source project
This is an open source project. You find a setup a setup guide and a detailed documentation about how it was created from scratch. You can use this information to create your own Telegram Bots and Mini Apps.

### Repository educational value
This repository has educational value as the details step-by-step documentation can be used as example and instruction guides for the following topics:
1. Telegram Bots creation fundamentals
2. Creation of the Backend API (for any web application, not only Telegram Mini Apps)
3. Telegram Mini Apps
   - General information
   - Backend Integration
     - Requests validation
   - Quick and Nice Templates without Design skills
   - Localizations \ translation for other languages (will be added soon)
   - Telegram Mini Apps API general approach
   - Telegram Mini Apps API examples of use
     - safe handling of Telegram initData
     - colorScheme and themeParams usage for styling your app
     - managing the viewport by expand() method and isExpended property
     - HapticFeedback usage
     - openTelegramLink() method usage
     - showPopup() method usage

# Setup Guide
> **NOTE:** There is no need to setup anything, if you want to use RateMate for your group or channel. Read the "How to use it" section about. Setup Guide is useful for cases where you want to make your own clone of this bot and mini app.

## Prerequisites
### Web Server
To store app's frontend abd backend files there is a need to have a web server with the following requirements:
- PHP 8.2+
- MySQL is supported
- SSH connection is supported
- SSL (https connection is supported)
- Composer 2 is supported

As the backend part is based on PHP Framework Symfony 6.3, there requirements are based on this article https://symfony.com/doc/current/setup.html#technical-requirements

#### Notes
- You can use VPS or a regular web hosting
- If you wish you can have 2 different web servers - for frontend and for backend. But this guide supposes you will have both backend and frontend files within one server.

## Step 1. Create a Telegram Bot to receive a token

### 1.1. Start a Chat with BotFather:
- Open Telegram and search for '@BotFather' in the search bar.
- Click on the BotFather from the search results to start a chat.
### 1.2. Create a New Bot:
- Click or type /newbot in the chat with BotFather.
- BotFather will ask you to choose a name for your bot. The name can be anything you like and is the name users will see in their chat list.
- Next, you'll be asked to choose a username for your bot. This must be unique and end with the word bot (e.g., my_test_bot or rateMateCloneBot).
### 1.3. Get the Token:
- Once you've set the name and username, BotFather will provide you with a token for your bot. This token will look something like this: 110215133:AAHdqTcv2H1vGWJxfSeofSAs0K5PALDsaw
- Make sure to keep this token safe and don't share it with anyone. This token allows you to control your bot and access the Telegram Bot API.

## Step 2. Create a Telegram Mini App

### 2.1. Start a Chat with BotFather:
- Open existed dialog with '@BotFather' bot you have from previous step.
### 2.2. Create a New Mini App:
- Click or type ```/newapp``` in the chat with BotFather.
- BotFather will ask you to choose the bot. Choose the bot you have created in the previous step.
- BotFather will ask you to enter a title. Enter and submit any title for your mini app (e.g., ```Rate Mate Clone```).
- BotFather will ask you to enter a short description. Enter and submit any short description for your mini app (e.g., ```Awesome Mini App to rate channels and groups```).
- BotFather will ask you to upload a photo, 640x360 pixels. Upload any image you wish respecting required size in pixels. Attach the file to chat with the bot and send it as regular photo. You can't skip this step.
- BotFather will ask you to upload a demo gif. Upload if you have one or send ```/empty``` command to skip this step.
- BotFather will ask you to enter a link. Send your app's "Frontend Link" - ```https://<your_domain>/app``` (the content of this URL will be rendered inside Telegram Mini App as iframe). This path is not active yet, but it will be after completion of this guide.
- BotFather will ask you to enter a short name for your Mini App. This name will be a part of the MiniApp URL, so it is a good idea to choose short and clear name (e.g., ```rate```)


## Step 3. Install the project on web server

### 3.1. Connect to your web server by SSH
If you don't know how to do this, you can use [this guide](https://help.one.com/hc/en-us/articles/115005585749-How-do-I-connect-to-my-web-space-using-SSH-) to connect to your web server. Also you can ask your web server provider fot additional instructions and credentials.

### 3.2. Configure the repository on your web server
_Execute the following commands in your terminal where you have opened an SSH connection:_

#### 3.2.1. Navigate to your root directory
``` 
$ cd ~
```

#### 3.2.2. Clone the repository to your web server:
``` 
$ git clone git@github.com:kossmokvin/TelegramRateMateBot.git
```

#### 3.2.3. Navigate to the repository directory
``` 
$ cd TelegramRateMateBot
```

#### 3.2.4. Create an .env file from .env.example file
``` 
$ cp .env.example .env
```

#### 3.2.5. Update the .env file
Open the ```~/TelegramRateMateBot/.env``` file using any File Manager (web server's admin panel integrated admin panel is also ok) and change the following credentials for yours:
``` 
// db_username, db_password,db_name - replace this substrings with your MySQL database credentials
DATABASE_URL="mysql://db_username:db_password@127.0.0.1:3306/db_name?serverVersion=8.0.32&charset=utf8mb4"
```
``` 
// Update this line with your Telegram Bot Token created on Step 1
TELEGRAM_BOT_TOKEN="<your_telegram_bot_token_here>"```
```

#### 3.2.6. Install the dependencies
``` 
$ composer install
```
**PROBLEM SOLVING:** If you have any issues executing this command, make sure that your server php version has version 8.2+ and your server composer has version 2 executing:
```
$ php -v
```
```
$ composer -V
```
If the versions do not match the requirements contact your web server provider and ask to assist to execute this commands with required versions of PHP and Composer.

If it is not possible - you can do this
- install PHP 8.2 and Composer 2 on your local computer
- clone the repository on your local computer
- execute steps 3.2.3 and 3.2.4 on your local computer
- execute ```composer install``` on your local computer
- then, upload your local folder ```TelegramRateMateBot``` on your web server

#### 3.2.7. Trigger the database migration
Assume that you already have a database created on your server (with the database name you specified in the .env file on step 1.2.5) and it has no tables created (empty)

Execute this command to create required database tables in your MySQL database. ()
```
$ php bin/console doctrine:migrations:migrate
```
**PROBLEM SOLVING:** This action also requires to be executed with PHP 8.2. If it is impossible to execute it on your server side within SSH, you can do this on your local repository, but before this you have to update your ```.env``` file with new new DATABASE_URL credentials proper for the connection to your database from localhost. 

Usually, you have to replace ```127.0.0.1:3306``` part of the string with the value your web server's value acceptable for external MySQL connections. And there might be additional configurations required on your web server's side, such as adding your IP into whitelist for external connections.  

#### 3.2.8. Make sure your web server looks into correct work directory
After steps 3.2.1-3.2.7 your main ```index.php``` file will be located by this path ~/TelegramRateMateBot/public/index.php```.

So your have to make sure that your web server (and attached domain) is properly configured to have ```~/TelegramRateMateBot/public``` as working directory.

If you use web hosting instead of VPS, sometimes they may use ```~/<your_domain>/public_html``` as working directory and there is no way to change it. In this case you can:
- Move all the files from existed ```~/TelegramRateMateBot``` directory into ```~/<your_domain>``` directory
- clone ```~/<your_domain>/public``` and name the clone directory as ```~/TelegramRateMateBot/public_html```
- visit ```~/<your_domain>/src/Controller/DefaultController.php``` and change ```'../public/miniapp/index.html'``` for ```'../public_html/miniapp/index.html'```

#### 3.2.9. Clear the caches
```
$ php bin/console cache:clear
```

#### 3.2.10. Check your web server
Open ```https://<your_domain>/test``` in web browser to check is everything is ok. Expected result is json response ```{ success: true }```

## Step 4. Update the Telegram Bot webhook configuration
Open this link in browser to set Telegram Endpoint for your bot. This will allow the bot the send a message with intro information for all people who will open your bot directly.

```
https://api.telegram.org/bot<YOUR_TELEGRAM_BOT_TOKEN>/setWebhook?url=https://<YOUR_DOMAIN>/telegram-bot-endpoint
```
If everything is done correctly, you will see the response
```{"ok":true,"result":true,"description":"Webhook was set"}```

## That's all! 
Your MiniApp will be available by link https://t.me/RateMateCloneBot/rate
(in case you hae chosen the ```RateMateCloneBot``` and ```rate``` values on step 2.2)

# Step by step Development Guide

To Learn more about the RateMateBot read the [Step by step Development Guide](https://smqn.notion.site/Step-by-step-Development-Guide-of-RateMate-Telegram-Bot-faf23f9e326e4c98b7e49eabb6141c53?pvs=4), where all the development process is described step by step and from the very beginning. You will know know about why the Symfony and Vue were chosen as a Framework for the MiniApp and how to use all their power to scale your MiniApp!

# Known issues...
- Reviews for bots are not available for the community (only for the author) as chat_instance of chat with bot is different for each user. 
