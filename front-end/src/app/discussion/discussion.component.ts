import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Discussion } from "./discussion.model";
import { DiscussionService } from "../_services/discussion.service";
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-place',
  templateUrl: './discussion.component.html',
  styleUrls: ['./discussion.component.scss']
})
export class DiscussionComponent implements OnInit {
  places: Discussion[] = [];

  constructor(public discussionService: DiscussionService) {}

  ngOnInit() {
    this.refreshList();
  }

  refreshList() {
    this.discussionService.getAll().subscribe((res) => {
      this.places = res as Discussion[];
    });
  }

  resetForm(form: NgForm) {
    form.reset();
  }

  onCreate(form: NgForm) {
    console.log(form.value);
      // stop here if form is invalid
      if (form.invalid) {
        return;
      }

      this.discussionService.createDiscussion(form.value).pipe(first())
        .subscribe(
          res => { this.refreshList(); this.resetForm(form); },
          error => { console.log(error.error); });
  }
}
