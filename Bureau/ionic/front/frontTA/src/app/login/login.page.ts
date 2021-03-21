import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  loginForm: FormGroup;


  constructor(private route: ActivatedRoute,
         private router: Router,
         private authentificationService: AuthService,
  ) { }

  ngOnInit() {
    this.initForm();
  }

  get f() { return this.loginForm.controls; }

  private initForm(){
    this.loginForm= new FormGroup({
       'email': new FormControl('fatou04.niang@gmail.com', Validators.required),
       'password': new FormControl('secret', Validators.required)
    })
 }

 onSubmit(){
   this.authentificationService.login(this.f.email.value, this.f.password.value)
   .subscribe({
     next:()=>{
       //console.log(this.authentificationService.getToken());
       //const returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
      // this.router.navigateByUrl(returnUrl);
       this.authentificationService.decodeToken();

     }
   })
 }
}
