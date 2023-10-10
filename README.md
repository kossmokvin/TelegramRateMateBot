# TODO
- Дописать про лицензию
- Апдейтни Фронтед линк

# About the Project
 [@RateMateBot](https://t.me/RateMateBot/) - is a Telegram Bot and related Telegram Mini App which allow users to rate to rate existed channels, channels and bots and leave public or anonymous reviews, while the Mini App shows the average rating and all community reviews.

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
   - Localizations (translation for other languages)
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
- PHP 8.1+
- MySQL database
- SSH connection is supported
- SSL (https connection is supported)
- Composer is supported

As the backend part is based on PHP Framework Symfony 6.3, there requirements are equal to https://symfony.com/doc/current/setup.html#technical-requirements

#### Notes
- You can use VPS or a regular web hosting
- If you wish you can have 2 different web servers - for frontend and for backend. But this guide supposes you will have both backend and frontend files within one server.

## Step 1. Install this project on web server

...

## Step 2. Create a Telegram Bot to receive a token

### 2.1. Start a Chat with BotFather:
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

### 1.1. Start a Chat with BotFather:
- Open existed dialog with '@BotFather' bot you have from previous step
### 1.2. Create a New Mini App:
- Click or type /newapp in the chat with BotFather.
- BotFather will ask you to choose the bot. Choose the bot you have created in the previous step.
- BotFather will ask you to enter a title. Enter and submit any title for your mini app (e.g., 'Rate Mate Clone'). 
- BotFather will ask you to enter a short description. Enter and submit any short description for your mini app (e.g., 'Awesome Mini App to rate channels and groups'). 
- BotFather will ask you to upload a photo, 640x360 pixels. Upload any image you wish respecting required size in pixels. Attach the file to chat with the bot and send it as regular photo. You can't skip this step.
- BotFather will ask you to upload a demo gif. Upload if you have one or send /empty command to skip this step.
- BotFather will ask you to send a link. Send your app's "Frontend Link". The content rendered by this URL will be shown inside Mini App Layer
