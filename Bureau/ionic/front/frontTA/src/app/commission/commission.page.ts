import { Component, OnInit } from '@angular/core';
import { TransactionsService } from '../services/transactions.service';
import { Transaction } from '../_model/transaction';

@Component({
  selector: 'app-commission',
  templateUrl: './commission.page.html',
  styleUrls: ['./commission.page.scss'],
})
export class CommissionPage implements OnInit {

  transactions: Transaction[]=[];

  constructor( private transactionService: TransactionsService) { }


  ngOnInit() {
    this.getTransaction()
  }

  getTransaction(){
    this.transactionService.getTransactions().
    subscribe(data=>{
      console.log(data);
      this.transactions=data
    })
  }

}
