import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertController, LoadingController } from '@ionic/angular';
import { DepotService } from '../services/depot.service';

@Component({
  selector: 'app-annulation-depot',
  templateUrl: './annulation-depot.page.html',
  styleUrls: ['./annulation-depot.page.scss'],
})
export class AnnulationDepotPage implements OnInit {

  segmentChang="beneficiaire";
  formRetrait: FormGroup;
  infos: any ;
  code: string;

  constructor(
    private depotService: DepotService,
    private forBuilder: FormBuilder,
    public alertController: AlertController,
    private loadingCtrl: LoadingController
    ) { }



  ngOnInit() {
    this.formRetrait= this.forBuilder.group({
      code: ['' ,Validators.required],
      //cni: ['' ,Validators.required],
      type: ['annulation',Validators.required]
    })
  }


  rechercher(code:string){
    const infos = {code: code , type: 'rechercher'};
    this.code= code;

    this.depotService.depot(infos).
    subscribe((res)=>{
      this.infos = res['data'];
      //console.log(this.infos);
    },(error)=>{
      console.log(error);
    });
  }


  async onSubmit(){
    let annulation= {code: this.code, type:'annulation'};
    //console.log(this.formRetrait.value);
    const alert = await this.alertController.create({
      header: 'confirmer',
        message: 'Etes-vous sur de vouloir annuler cette transaction',
        buttons: [
          {
            text: 'Annuler',
            handler: ()=>{},
          },
          {
            text:'Confirmer',
            handler: async () => {
              const loading= await this.loadingCtrl.create();
              await loading.present();
              this.depotService.depot(annulation).
              subscribe(async(data)=>{
                await loading.dismiss();
                const alert2= await this.alertController.create({
                  header: 'Annulation de transfert reussi',
                  //subHeader: 'INFOS',
                  //message: `vous avez retiré`,
                  buttons: ['Fermé']
                });
                  await alert2.present();
                  this.formRetrait.reset();
              },async (error) => {
                console.log(error);
                await loading.dismiss();

                const alert2 = await this.alertController.create({
                  header: 'Failled',
                  //subHeader: 'INFOS',
                  message: error.error.message,
                  buttons: ['Fermer']
                });
                await alert2.present();
              })
            }
          }
        ]
    })
    await alert.present();
  }
  ///

}
