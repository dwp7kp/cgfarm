import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { HttpClient } from '@angular/common/http';
import { Account } from './account';

export interface DialogData {
  url: string;
}

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'webpl-project';
  loggedin = false;
  urlset = false;
  account = new Account(null, null, null, null, null);
  loginurl = '';

  constructor(public dialog: MatDialog, private http: HttpClient) { }

  setURL() {
    this.urlset = true;
    this.http.post<string>('http://localhost/cs4640/cgfarm/login.php','login=true').subscribe((data) => {
      this.loginurl = data;
      console.log("Data", data);
      console.log("Var", this.loginurl, this.loginurl['post_loginurl']);
    }, (error) => {
      console.log('Error', error);
    })
  }

  openDialog(): void {
    //this.loggedin = !this.loggedin;
    console.log("hey");
    //waitsFor(this.setURL);
    const dialogRef = this.dialog.open(DialogOverviewExampleDialog, {
      width: '250px',
      data: { url: this.loginurl }
    });

    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
      //this.animal = result;
    });
  }

  logout() {
    // TODO: currently not storing the token in Angular :/
  }
}

@Component({
  selector: 'dialog-overview-example-dialog',
  templateUrl: 'dialog-overview-example-dialog.html',
})
export class DialogOverviewExampleDialog {

  constructor(
    public dialogRef: MatDialogRef<DialogOverviewExampleDialog>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData) { }

  onNoClick(): void {
    this.dialogRef.close();
  }

}
