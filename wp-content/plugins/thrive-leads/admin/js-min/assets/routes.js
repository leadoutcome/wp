/*! Thrive Leads - The ultimate Lead Capture solution for wordpress - 2018-01-12
* https://thrivethemes.com 
* Copyright (c) 2018 * Thrive Themes */

var ThriveLeads=ThriveLeads||{};jQuery(function(){var a=Backbone.Router.extend({routes:{assets:"assets"},assets:function(){var a=new ThriveLeads.views.Assets({model:ThriveLeads.objects.AssetsWizard,collection:ThriveLeads.objects.AssetsCollection,el:"#tve-asset-delivery"}),b=new ThriveLeads.views.Breadcrumbs({collection:ThriveLeads.objects.BreadcrumbsCollection,el:"#tve-leads-breadcrumbs"});a.globalSettings=TVE_Page_Data.globalSettings,a.render(),b.render()}});ThriveLeads.router=new a,Backbone.history.start({hashChange:!0})});