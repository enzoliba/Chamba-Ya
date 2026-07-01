<style>
    header a{
        text-decoration: none;
        color: #000;
    }

    .menu-toggle{
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        width: 30px;
        height: 30px;
        padding: 0;
    }

    .menu-toggle .bar{
        width: 100%;
        height: 3px;
        background-color: #343a40;
        margin: 5px 0;
        transition: 0.4s;
        border-radius: 2px;
    }

    .main-header{
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 30px;
        background: white;
        position:sticky;
        top: 0;
        z-index: 1000;
    }

    .main-nav {
        display: flex;
        gap: 60px;
    }

    .nav-links{
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 100px;
    }

    .nav-links li{
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .actions{
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .search_box {
        position: relative;
        width: 300px;
    }

    .search_box input{
        width: 100%;
        padding: 10px 45px 10px 20px; 
        border: 1px solid #ccc;
        border-radius: 25px; 
        outline: none;
        font-size: 16px;
    }

    .search_box i {
        position: absolute;
        right: 15px; 
        top: 50%;
        transform: translateY(-50%);
        color: #000;
    }

    .user_box{
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user_menu{
        position: absolute;
        top: 70px;
        right: 0;
        background: #fff;
        border: 2px solid #000;
        border-radius: 10px;
        padding: 10px 0;
        width: 225px;
        opacity: 0;
        visibility: hidden;
        transition: .3s;
    }

    .user_menu.active{
        opacity: 1;
        visibility: visible;
    }

    .user_menu a{
        display: block;
        padding: 10px;
        color: #000;
        text-decoration: none;
    }

    .user_menu a:hover{
        background: #f0f0f0;
    }

    .user_menu p{
        padding: 10px;
        margin: 0;
        font-weight: bold;
    }

    .user_box button{
        background-color : #EADDFF;
        border: none;
        padding: 20px;
        border-radius: 32px;
        cursor: pointer;
    }
    .user_box button i{
        color: #000;
        font-size: 25px;
    }

    @media (max-width: 1050px) {
        .main-header{
            flex-wrap: wrap;
            padding: 15px 20px;
        }

        .logo_web{
            width: 150px;
        }

        .menu-toggle{
            display: block;
        }

        .main-nav{
            position: absolute;
            top: 80px;
            left: 0;
            width: 100%;
            background: #fff;
            transform: translateY(-100vh);
            transition: .4s;
            opacity: 0;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            padding: 0;
            gap : 0;
            z-index: 999;
        }

        .main-nav.open{
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }

        .nav-links{
            flex-direction: column;
            gap: 0;
            width: 100%;
        }

        .nav-links li{
            width: 100%;
            border-bottom: 1px solid #eee;
            justify-content: left;
            padding: 10px;
        }

        .nav-links a{
            display: block;
            padding: 15px 20px;
        }

        .actions{
            display: flex;
            flex-direction: column;
            width: 100%;
            padding: 20px;
            gap: 15px;
        }

        .search_box{
            width: 100%;
        }

        .search_box input{
            width: 100%;
        }

        .user_box{
            width: 100%;
            display: grid;
        }

        .user_box button{
            width: 100%;
            border-radius: 10px;
            padding: 12px;
        }

        .user_menu{
            position: static;
            width: 100%;
            opacity: 1;
            visibility: visible;
            border: 1px solid #ddd;
            margin-top: 10px;
            display: none;
        }

        .user_menu.active{
            display: block;
        }
    }
    /* ===== Notificaciones desplegables ===== */
    .notif_box{ position: relative; display: flex; align-items: center; margin-right: 6px; }
    /* .user_box .notif-bell : mayor especificidad para ganarle a ".user_box button" (que lo hacía un círculo morado grande) */
    .user_box .notif-bell{ position: relative; background: none; border: none; cursor: pointer; font-size: 24px; color: #000; padding: 8px; display: flex; align-items: center; width: auto; border-radius: 50%; }
    .user_box .notif-bell:hover{ background: #f0f0f0; }
    .notif-badge{ position: absolute; top: -2px; right: -2px; background: #dc2626; color: #fff; font-size: 11px; font-weight: 700; min-width: 17px; height: 17px; border-radius: 9px; display: flex; align-items: center; justify-content: center; padding: 0 4px; }
    .notif_menu{ position: absolute; top: 52px; right: 0; width: 330px; max-height: 430px; overflow-y: auto; background: #fff; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,.12); opacity: 0; visibility: hidden; transform: translateY(-8px); transition: .2s; z-index: 1200; }
    .notif_menu.active{ opacity: 1; visibility: visible; transform: translateY(0); }
    .notif_menu_header{ padding: 12px 16px; font-weight: 700; border-bottom: 1px solid #eee; }
    .notif_item{ display: flex; gap: 10px; padding: 12px 16px; border-bottom: 1px solid #f1f1f1; color: #1e293b; text-decoration: none; align-items: flex-start; }
    .notif_item:hover{ background: #f8f9fa; }
    .notif_item.no-leida{ background: #faf5ff; }
    .notif_item div{ display: flex; flex-direction: column; }
    .notif_item small{ color: #94a3b8; font-size: .75rem; margin-top: 2px; }
    .notif_empty{ padding: 18px 16px; color: #64748b; text-align: center; }
    .notif_ver_todas{ display: block; text-align: center; padding: 12px; color: #7c3aed; font-weight: 600; text-decoration: none; }
    .notif_ver_todas:hover{ background: #f8f9fa; }

    @media (max-width: 1050px){
        .notif_menu{ width: 280px; right: auto; left: 0; }
    }
</style>