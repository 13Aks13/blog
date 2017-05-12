"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var core_1 = require("@angular/core");
var platform_browser_1 = require("@angular/platform-browser");
var forms_1 = require("@angular/forms");
var http_1 = require("@angular/http");
// import { MomentModule }  from 'angular2-moment';
var app_component_1 = require("./app.component");
var app_routing_1 = require("./app.routing");
// Services
var user_service_1 = require("./services/user.service");
var auth_guard_1 = require("./services/auth.guard");
var alert_service_1 = require("./services/alert.service");
// Components
var alert_component_1 = require("./alert/alert.component");
var login_component_1 = require("./login/login.component");
var register_component_1 = require("./register/register.component");
var authentication_service_1 = require("./services/authentication.service");
var home_component_1 = require("./home/home.component");
var AppModule = (function () {
    function AppModule() {
    }
    return AppModule;
}());
AppModule = __decorate([
    core_1.NgModule({
        imports: [
            platform_browser_1.BrowserModule,
            forms_1.FormsModule,
            http_1.HttpModule,
            //      MomentModule,
            app_routing_1.AppRoutingModule,
        ],
        declarations: [
            app_component_1.AppComponent,
            alert_component_1.AlertComponent,
            login_component_1.LoginComponent,
            register_component_1.RegisterComponent,
            home_component_1.HomeComponent,
        ],
        providers: [
            auth_guard_1.AuthGuard,
            alert_service_1.AlertService,
            authentication_service_1.AuthenticationService,
            user_service_1.UserService,
        ],
        bootstrap: [app_component_1.AppComponent]
    })
], AppModule);
exports.AppModule = AppModule;
//# sourceMappingURL=app.module.js.map