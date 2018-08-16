<?php
/******************************************************
* IM - Vocabulary Builder
* Version : 1.0.2
* Copyright© 2016 Imprevo Ltd. All Rights Reversed.
* This file may not be redistributed.
* Author URL:http://imprevo.net
******************************************************/
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ Config::get('SITE_TITLE') }}</title>
  <meta name="keywords" content="HTML5 Admin Template" />
  <meta name="description" content="Porto Admin - Responsive HTML5 Template">
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />


  <!-- Web Fonts  -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.css" />

  <link rel="stylesheet" href="/assets/vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="/assets/vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

  <!-- Specific Page Vendor CSS -->
  <link rel="stylesheet" href="/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />

  <link rel="stylesheet" href="/assets/vendor/bootstrap-formhelper/bootstrap-formhelpers.min.css" />
  <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.css" />
  <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.theme.css" />
  <link rel="stylesheet" href="/assets/vendor/select2/css/select2.css" />
  <link rel="stylesheet" href="/assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
  <link rel="stylesheet" href="/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
  <link rel="stylesheet" href="/assets/vendor/pnotify/pnotify.custom.css" />
  <link rel="stylesheet" href="/assets/vendor/summernote/summernote.css" />

  <!-- Theme CSS -->
  <link rel="stylesheet" href="/assets/stylesheets/theme.css" />

  <!-- Skin CSS -->
  <link rel="stylesheet" href="/assets/stylesheets/skins/default.css" />

  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="/assets/stylesheets/theme-custom.css">

  <!-- Head Libs -->
  <script src="/assets/vendor/modernizr/modernizr.js"></script>
  <script src="/assets/vendor/jquery/jquery.js"></script>
  <script src="/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
  <script src="/assets/vendor/bootstrap-formhelper/bootstrap-formhelpers.min.js"></script>
  <script src="/assets/vendor/underscore/underscore-min.js"></script>
  <script src="/assets/vendor/async/async.min.js"></script>
  <script src="/assets/vendor/summernote/summernote.js"></script>
  <script src="/assets/vendor/pnotify/pnotify.custom.js"></script>
</head>
<body>
  <section class="body">
    <!-- start: header -->
    <header class="header">
      <div class="logo-container">
        <a href="/" class="logo" style="">
          <img src="/images/logo.png" height="50" alt="Arcana Admin" />
          <h2 style="display:inline;color:#2cb1d1;position:relative;top: 5px;left: 0px;">CatoCoin</h2>
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
          <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
      </div>

      <!-- start: search & user box -->
      <div class="header-right">


<span class="separator"></span>

<div id="userbox" class="userbox">
  <a href="#" data-toggle="dropdown">
    <figure class="profile-picture">
      <img src="@if (Auth::user()->photo == null) /assets/images/!logged-user.jpg @else /public{{Auth::getUser()->photo}} @endif" class="img-circle" alt="User Image">
    </figure>
    <div class="profile-info" data-lock-name="{{ Auth::user()->name}}" data-lock-email="{{ Auth::user()->email}}">
      <span class="name">{{ Auth::user()->first_name}}</span>
    </div>

    <i class="fa custom-caret"></i>
  </a>

  <div class="dropdown-menu">
    <ul class="list-unstyled">
      <li class="divider"></li>
      <li>
        <a role="menuitem" tabindex="-1" href="/profile"><i class="fa fa-user"></i> My profile</a>
      </li>
      <li>
        <a role="menuitem" tabindex="-1" href="{{ url('/logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
      </li>
    </ul>
  </div>
</div>
</div>
<!-- end: search & user box -->
</header>
<!-- end: header -->

<div class="inner-wrapper">
  <!-- start: sidebar -->
  <aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
      <div class="sidebar-title">
        Navigation
      </div>
      <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
      </div>
    </div>

    <div class="nano">
      <div class="nano-content">
        <nav id="menu" class="nav-main" role="navigation">
          <ul class="nav nav-main">
            <li>
              <a href="/home">
                <i class="fa fa-desktop"></i> <span>Dashboard</span>
              </a>
            </li>

            <li class="nav-parent">
              <a>
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>User management</span>
              </a>
              <ul class="nav nav-children">
                <li>
                  <a href="/users">
                    User list
                  </a>
                </li>
                <!-- <li>
                  <a href="/users/referral">
                    Referral list
                  </a>
                </li> -->
                <li>
                  <a href="/users/new">
                    Add new user
                  </a>
                </li>
              </ul>
            </li>

            <li>
              <a href="/#">
                <i class="fa fa-book"></i> <span>Transactions</span>
              </a>
            </li>

            <li class="nav-parent">
              <a>
                <i class="fa fa-gear" aria-hidden="true"></i>
                <span>Settings</span>
              </a>
              <ul class="nav nav-children">
                <li>
                  <a href="/site_settings">
                    General Setting
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>

      <script>
      // Maintain Scroll Position
      if (typeof localStorage !== 'undefined') {
        if (localStorage.getItem('sidebar-left-position') !== null) {
          var initialPosition = localStorage.getItem('sidebar-left-position'),
          sidebarLeft = document.querySelector('#sidebar-left .nano-content');

          sidebarLeft.scrollTop = initialPosition;
        }
      }
      </script>
    </div>
  </aside>
  <!-- end: sidebar -->
  <div class="w100">
    @yield('content')
  </div>
</div>
</section>
<!-- Vendor -->
<script src="/assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="/assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="/assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="/assets/vendor/jquery-ui/jquery-ui.js"></script>
<script src="/assets/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
<script src="/assets/vendor/autosize/autosize.js"></script>
<script src="/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="/assets/vendor/jquery-validation/jquery.validate.js"></script>
<script src="/assets/vendor/select2/js/select2.js"></script>
<script src="/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="/assets/vendor/ios7-switch/ios7-switch.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="/assets/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="/assets/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="/assets/javascripts/theme.init.js"></script>
<script src="/assets/javascripts/common.js"></script>
<script src="/assets/vendor/fuelux/js/spinner.js"></script>

</body>
</html>
