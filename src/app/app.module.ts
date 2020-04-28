import { BrowserModule } from '@angular/platform-browser';
import { NgModule, NO_ERRORS_SCHEMA } from '@angular/core';

import { AppComponent, DialogOverviewExampleDialog } from './app.component';
import { BaseComponent } from './base/base.component';
import { AppointmentComponent } from './appointment/appointment.component';

// Tutorial on how to do this headache -> https://www.npmjs.com/package/angular-bootstrap-md
import { MDBBootstrapModule } from 'angular-bootstrap-md';
// For MDB Angular Free
import { NavbarModule, WavesModule, ButtonsModule } from 'angular-bootstrap-md';

import { HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { MatDialogModule } from '@angular/material/dialog';
import { MatNativeDateModule } from '@angular/material/core';
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';
import { DemoMaterialModule } from './material-module';
import { MAT_FORM_FIELD_DEFAULT_OPTIONS } from '@angular/material/form-field';
//import {DialogOverviewExample, DialogOverviewExampleDialog} from './app/dialog-overview-example';


// Routing
import { RouterModule, Routes } from '@angular/router';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AboutComponent } from './about/about.component';

const appRoutes: Routes = [
  { path: 'home', component: BaseComponent},
  { path: 'about', component: AboutComponent},
  //{ path: 'animals', component: BaseComponent},
  { path: 'store', component: AppointmentComponent},
  { path: '', redirectTo: 'home', pathMatch: 'full'},
  /*
  {
    path: 'heroes',
    component: HeroListComponent,
    data: { title: 'Heroes List' }
  },
  { path: '**', component: PageNotFoundComponent } */
];

@NgModule({
  declarations: [
    AppComponent,
    BaseComponent,
    AppointmentComponent,
    AboutComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    NavbarModule,
    WavesModule,
    ButtonsModule,
    MDBBootstrapModule.forRoot(),
    DemoMaterialModule,
    MatNativeDateModule,
    MatDialogModule,
    ReactiveFormsModule,
    BrowserAnimationsModule,
    HttpClientModule,

    RouterModule.forRoot(
      appRoutes,
      { enableTracing: true } // <-- debugging purposes only
    )
  ],
  entryComponents: [
    DialogOverviewExampleDialog
  ],
  schemas: [ NO_ERRORS_SCHEMA ],
  providers: [
    { provide: MAT_FORM_FIELD_DEFAULT_OPTIONS, useValue: { appearance: 'fill' } },
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}

platformBrowserDynamic().bootstrapModule(AppModule)
  .catch(err => console.error(err));
