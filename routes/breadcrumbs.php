<?php

Breadcrumbs::for ('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for ('user.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('user.index'));
});

//------------ Call Tracker ------------//
Breadcrumbs::for ('leads.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Call Tracking', route('leads.index'));
});

//------------ Available Numbers ------------//
Breadcrumbs::for ('available_numbers.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Call Tracking', url('/call-tracking'));
    $trail->push('Available Numbers', route('available_numbers.index'));
});

//------------ Role ------------//
Breadcrumbs::for ('role.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Role', route('role.index'));
});

//------------ Permission ------------//
Breadcrumbs::for ('permission.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Permission', route('permission.index'));
});

//------------ Lead ------------//
Breadcrumbs::for ('lead.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Lead', route('lead.index'));
});

//------------ Lead Source ------------//
Breadcrumbs::for ('lead-source.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Settings');
    $trail->push('Lead');
    $trail->push('Lead Sources', route('lead-source.index'));
});

//------------ Lead Status ------------//
Breadcrumbs::for ('lead-status.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Settings');
    $trail->push('Lead');
    $trail->push('Lead Status', route('lead-status.index'));
});

//------------ Lead Status ------------//
Breadcrumbs::for ('lead-type.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Settings');
    $trail->push('Lead');
    $trail->push('Lead Type', route('lead-type.index'));
});

//------------ Web2lead Form ------------//
Breadcrumbs::for ('form.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Settings');
    $trail->push('Lead');
    $trail->push('Web2Lead Form', route('form.index'));
});

//------------ Web2lead Form Submission ------------//
Breadcrumbs::for ('form.submission.index', function ($trail, $form) {
    $trail->parent('form.index');
    $trail->push('Submission');
    $trail->push($form->name, route('form.submission.index', $form));
});

//------------ Web2lead Form Submission View ------------//
Breadcrumbs::for ('form.submission.show', function ($trail, $submission) {
    $trail->parent('form.submission.index', $submission->form);
    $trail->push('Lead -' . ' ' . $submission->content['name'], route('form.submission.show', [$submission->form, $submission->id]));
});

//------------ Ticket ------------//
Breadcrumbs::for ('ticket.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Ticket', route('ticket.index'));
});

//------------ Ticket Status ------------//
Breadcrumbs::for ('ticket-status.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Settings');
    $trail->push('Ticket');
    $trail->push('Ticket Status', route('ticket-status.index'));
});

//------------ Ticket Priority ------------//
Breadcrumbs::for ('ticket-priority.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Settings');
    $trail->push('Ticket');
    $trail->push('Ticket Priority', route('ticket-priority.index'));
});

//------------ Ticket Service ------------//
Breadcrumbs::for ('ticket-service.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Settings');
    $trail->push('Ticket');
    $trail->push('Ticket Service', route('ticket-service.index'));
});

//------------ Department ------------//
Breadcrumbs::for ('department.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Department', route('department.index'));
});

Breadcrumbs::for ('setup', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Setup');
});



//------------ Reviews ------------//
Breadcrumbs::for ('reviews.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Reviews', route('reviews.index'));
});