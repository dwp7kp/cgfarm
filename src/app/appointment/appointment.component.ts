import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Item } from './item';

@Component({
  selector: 'app-appointment',
  templateUrl: './appointment.component.html',
  styleUrls: ['./appointment.component.css']
})
export class AppointmentComponent implements OnInit {

  ngOnInit(): void {
  }

  items = [
    { name: "apple", description: "A suculent red apple", price: "10", type: "fruit"},
    { name: "pear", description: "Definitly not an orage", price: "12", type: "fruit"},
    { name: "grapes", description: "The kind that makes jelly and wine", price: "13", type: "fruit"},
    { name: "sausage", description: "It's suasage!", price: "2", type: "pork"},
    { name: "pork chop", description: "The chop of the pig", price: "1", type: "pork"},
    { name: "pork butt", description: "The shoulder of the pig", price: "8", type: "pork"},
    { name: "sirloin", description: "A sirloin steak", price: "55", type: "beef"},
    { name: "t-bone", description: "A t-bone steak", price: "81", type: "beef"},
    { name: "flank", description: "A flank steak", price: "9001", type: "beef"}
    
  ];

  hide_split = false;
  hide_container = true;

  show_pork = true;
  show_beef = true;
  
  input_email = "";

  changeView(name) {
    if (name === 'create') {
      this.hide_split = !this.hide_split;
      this.hide_container = !this.hide_container;
      //document.getElementById("split").style.display = "none";
      //document.getElementById("create").style.display = "block";
    } else {
      document.getElementById("split").style.display = "none";
      document.getElementById("modify").style.display = "block";
      document.getElementById("modify").innerHTML
    }
  }

  filterSelection = (type) => {
    
  }

  constructor(private http: HttpClient) { }
  addToCart(item, price) {
    console.log("email", this.input_email);
    this.http.get<Item>('http://localhost/cs4640/cgfarm/store.php?operation=insert&email=' + this.input_email + '&table=item&item=' + item + '&price=' + price).subscribe((data) => {
      console.log("Data", data);
    }, (error) => {
      console.log('Error', error);
    })
    //console.log();
  }

}
