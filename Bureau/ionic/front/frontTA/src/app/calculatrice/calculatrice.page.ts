import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { DepotService } from '../services/depot.service';

@Component({
  selector: 'app-calculatrice',
  templateUrl: './calculatrice.page.html',
  styleUrls: ['./calculatrice.page.scss'],
})
export class CalculatricePage implements OnInit {

  formCalcul: FormGroup;
  frais;

  constructor(
    private depotService: DepotService,
    private formbuild: FormBuilder
  ) { }

  ngOnInit() {
    this.formCalcul= this.formbuild.group({
      type:["Depot",Validators.required],
      montant:["", Validators.required]
    });

  }


getFrais(montant:number){
  montant = Number(montant);
    if(montant<500){
      this.frais = 0;
    }else{
      this.frais=this.depotService.calcalueFraisTransfert(Number(montant));
    }
  }
}
