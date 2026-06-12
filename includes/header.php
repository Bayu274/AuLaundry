<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($pageTitle ?? 'AuLaundry') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body, html {
      height: 100%;
      margin: 0;
      overflow-x: hidden;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    /* Header */
    header {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 60px;
      background-color: #005bea;
      color: white;
      display: flex;
      align-items: center;
      padding: 0 20px;
      z-index: 1050;
    }
    #sidebarToggle {
      font-size: 1.5rem;
      cursor: pointer;
      background: none;
      border: none;
      color: white;
      padding: 5px 10px;
      display: none;
      z-index: 1060;
    }
    header .brand {
      font-weight: 700;
      font-size: 1.25rem;
      margin-left: 10px;
    }
    /* Sidebar */
    #sidebar {
      position: fixed;
      top: 60px;
      left: 0;
      width: 260px;
      height: calc(100% - 60px);
      background-color: #070d19;
      color: #a3b1cc;
      overflow-y: auto;
      transition: transform 0.3s ease;
      transform: translateX(0);
      z-index: 1040;
    }
    #sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    #sidebar a {
      display: block;
      padding: 12px 20px;
      color: inherit;
      text-decoration: none;
      transition: background-color 0.3s;
    }
    #sidebar a.active, #sidebar a:hover {
      background-color: #1a2536;
      color: white;
    }
    #sidebar .sidebar-header {
      font-size: 1.2rem;
      font-weight: 700;
      padding: 20px;
      color: #00c6fb;
      border-bottom: 1px solid #1a2536;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    #sidebar .close-btn {
      font-size: 1.5rem;
      cursor: pointer;
      background: none;
      border: none;
      color: #00c6fb;
      display: none;
    }
    /* Overlay */
    #sidebarOverlay {
      position: fixed;
      top: 60px;
      left: 0;
      width: 100%;
      height: calc(100% - 60px);
      background: rgba(0,0,0,0.5);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
      z-index: 1035;
    }
    #sidebarOverlay.show {
      opacity: 1;
      visibility: visible;
    }
    /* Content area */
    #content {
      margin-top: 60px;
      margin-left: 260px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }
    /* Desktop */
    @media (min-width: 992px) {
      #sidebar {
        transform: translateX(0);
      }
      #sidebarToggle {
        display: none;
      }
      #sidebar .close-btn {
        display: none;
      }
      #content {
        margin-left: 260px;
      }
    }
    /* Mobile */
    @media (max-width: 991.98px) {
      #sidebarToggle {
        display: inline-block;
      }
      #sidebar {
        transform: translateX(-260px);
      }
      #sidebar.show {
        transform: translateX(0);
      }
      #sidebar .close-btn {
        display: inline-block;
      }
      #content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
  <header>
    <button type="button" id="sidebarToggle" aria-label="Toggle sidebar">
      <i class="fa-solid fa-bars"></i>
    </button>
    <div class="brand">AuLaundry</div>
  </header>
