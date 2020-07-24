import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DiscussionComponent } from "./discussion/discussion.component";

const routes: Routes = [
  { path:'', component:DiscussionComponent },
  { path:'discussion', component:DiscussionComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
