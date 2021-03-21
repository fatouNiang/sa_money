export interface Transaction {

      id: number,
      montant: string,
      dateDepot: Date,
      dateRetrait: Date,
      code: string,
      frais: number,
      fraisDepot: number,
      fraisRetrait: number,
      fraisSystem: number,
      fraisEtat: number,
      userDepot: any,
      UserRetrait: any,
      clientDepot: any,
      clientRetrait: any,
      userRetrait: any,
      type: string
}
