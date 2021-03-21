export interface Depot {

  id: number,
  montant: string,
  dateDepot: Date,
  dateRetrait: Date,
  code: string,
  frais: number,
  fraisDepot: number;
  fraisRetrait:number;
  fraisSystem:number;
  fraisEtat:number;
  userDepot: any;
  profil:any;
  clientDepot:any;

}
