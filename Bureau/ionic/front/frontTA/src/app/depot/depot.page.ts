import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertController, LoadingController } from '@ionic/angular';
import { DepotService } from '../services/depot.service';


@Component({
  selector: 'app-depot',
  templateUrl: './depot.page.html',
  styleUrls: ['./depot.page.scss'],
})
export class DepotPage implements OnInit {

  formDepot: FormGroup;
  segmentChang="emetteur";
  frais;

  constructor(
    private DepotService: DepotService,
    private forBuilder: FormBuilder,
    public alertController: AlertController,
    private loadingCtrl: LoadingController
    ) { }



  ngOnInit() {
    this.formDepot= this.forBuilder.group({
      montant: ['',Validators.required],
      clientDepot: this.forBuilder.group({
        nomComplet: ["", Validators.required],
        telephone: ["", Validators.required],
        CNI: ["", Validators.required],
      }),
      clientRetrait: this.forBuilder.group({
        nomComplet: ["", Validators.required],
        telephone: ["", Validators.required],
      }),
      type: ['depot',Validators.required]
    })
  }

  async depot(){
    console.log(this.formDepot.value);

    const alert = await this.alertController.create({
      header: 'Confirmer',
      message: 'voulez vous effectuer un depot',

      buttons: [
        {
          text: 'Annuler',
          handler: () => {

          }
        },
        {
          text: 'OUI',
          handler: async () => {
            const loading = await this.loadingCtrl.create();
            await loading.present();
            this.DepotService.depot(this.formDepot.value).
            subscribe(async (data)=>{
              console.log(data);

              await loading.dismiss();
              const alert2 = await this.alertController.create({
                header: 'transfert reussi',
                subHeader: 'INFOS',
                message: `vous avez envoyé ${this.formDepot.value.montant} à  ${this.formDepot.value.clientRetrait.nomComplet} le ....`,
                buttons: ['OK']
              });

              await alert2.present();
              this.formDepot.reset();
            },async (error)=>{
              console.log(error);

              await loading.dismiss();
              const alert2 = await this.alertController.create({
                header: 'erreur',
                subHeader: 'INFOS',
                message: error.error.message,
                buttons: ['OK']
              });
              await alert2.present();
            });

          }
        }
      ]
    });
    await alert.present();
}

     getFrais(montant:number){
      montant = Number(montant);
        if(montant<500){
          this.frais = 0;
        }else{
          this.frais=this.DepotService.calcalueFraisTransfert(Number(montant));
        }



     }
}
