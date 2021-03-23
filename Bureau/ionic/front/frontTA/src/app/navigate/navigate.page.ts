import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
//import { menuController } from 'https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/index.esm.js';
//window.menuController = menuController;
import { MenuController, NavController } from '@ionic/angular';
import { AuthService } from '../services/auth.service';
import { DepotService } from '../services/depot.service';


@Component({
  selector: 'app-navigate',
  templateUrl: './navigate.page.html',
  styleUrls: ['./navigate.page.scss'],
})
export class NavigatePage implements OnInit {
  private id: any;
  public solde: any=[];

 constructor(
   private nav: NavController,
  private authService: AuthService,
  private depoService: DepotService,
) { }

  ngOnInit() {
    this.getSolde();
  }

  getSolde(){
    this.depoService.getSolde().subscribe((data)=>{
      console.log(data);
     this.solde=data})
  }

  getDepot(){
  this.nav.navigateForward("depot")
  }
  getRetrait(){
  this.nav.navigateForward("retrait")
  }
  getAnnulation(){
    this.nav.navigateForward("annulation-depot")
  }
  getTransactions(){
  this.nav.navigateForward("/tabs/transaction")
  }
  getCalculatrice(){
  this.nav.navigateForward("/tabs/calculatrice")
  }

  getCommission(){
    this.nav.navigateForward("/tabs/commission")
    }

  logout(){
  this.authService.logout();
  }

}
