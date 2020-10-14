import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './routes/app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './header/header.component';
import { AuthComponent } from './routes/auth/auth.component';
import { LoginComponent } from './routes/login/login.component';
import { RegisterComponent } from './routes/register/register.component';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpClientModule} from '@angular/common/http';
import { AboutComponent } from './routes/about/about.component';
import { LogoutComponent } from './routes/logout/logout.component';
import { PlayerComponent } from './players/player/player.component';
import { PlaylistComponent } from './players/playlist/playlist.component';
import {CommonModule} from '@angular/common';
import { MusicComponent } from './routes/music/music.component';
import { MessagesComponent } from './routes/messages-routers/messages/messages.component';
import { PlayerPopupComponent } from './players/player-popup/player-popup.component';
import { PlayerTopComponent } from './players/player-top/player-top.component';
import { LeftSidebarComponent } from './left-sidebar/left-sidebar.component';
import { UserPageComponent } from './routes/custom-routers/users/user-page/user-page.component';
import { UserAuthPageComponent } from './routes/custom-routers/users/user-auth-page/user-auth-page.component';
import { UserIdPageComponent } from './routes/custom-routers/users/user-id-page/user-id-page.component';
import { CustomRouterComponent } from './routes/custom-routers/custom-router/custom-router.component';
import { DialogMessagesComponent } from './routes/messages-routers/dialog-messages/dialog-messages.component';
import { AllDialogsComponent } from './routes/messages-routers/all-dialogs/all-dialogs.component';
import { MessagesRightSidebarComponent } from './routes/messages-routers/messages-right-sidebar/messages-right-sidebar.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    AuthComponent,
    LoginComponent,
    RegisterComponent,
    AboutComponent,
    LogoutComponent,
    PlayerComponent,
    PlaylistComponent,
    MusicComponent,
    MessagesComponent,
    PlayerPopupComponent,
    PlayerTopComponent,
    LeftSidebarComponent,
    UserPageComponent,
    UserAuthPageComponent,
    UserIdPageComponent,
    CustomRouterComponent,
    DialogMessagesComponent,
    AllDialogsComponent,
    MessagesRightSidebarComponent,
  ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,
    ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
