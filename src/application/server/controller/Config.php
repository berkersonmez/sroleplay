<?php
class C_Config {
    /* Security */
    const SEARCH_FLOOD_PROTECTION_TIMEOUT = 3; // seconds
    const USER_REMEMBER_COOKIE_TIME = 5184000; // seconds

    const LOG_MAX_ALLOWED = 4; // +1 times
    const LOG_USER_ALLOWED_AFTER_SECONDS = 300; // seconds
    const LOG_DELETE_AFTER_SECONDS = 300; // seconds
    const LOG_USER_ALLOWED_IOS_ASKING_AFTER_SECONDS = 600; // seconds
    const LOG_MAX_IOS_ASKING_ALLOWED = 4; // +1 times

    public static $cities = array("Adana", "Adapazarı", "Adıyaman", "Afyon", "Ağrı", "Aksaray", "Amasya", "Ankara", "Antalya", "Ardahan", "Artvin", "Aydın", "Balıkesir", "Bartın", "Batman", "Bayburt", "Bilecik", "Bingöl", "Bitlis", "Bolu", "Burdur", "Bursa", "Çanakkale", "Çankırı", "Çoklu Teslim", "Çorum", "Denizli", "Diyarbakır", "Düzce", "Edirne", "Elazığ", "Erzincan", "Erzurum", "Eskişehir", "Gaziantep", "Giresun", "Gümüşhane", "Hakkari", "Hatay", "İçel", "Iğdır", "Isparta", "İstanbul", "İzmir", "K.Maraş", "Karabük", "Karaman", "Kars", "Kastamonu", "Kayseri", "Kıbrıs-Gazimagosa", "Kıbrıs-Girne", "Kıbrıs-Güzelyurt", "Kıbrıs-Lefkoşe", "Kilis", "Kırıkkale", "Kırklareli", "Kırşehir", "Kocaeli", "Konya", "Kütahya", "Malatya", "Manisa", "Mardin", "Muğla", "Muş", "Nevşehir", "Niğde", "Ordu", "Osmaniye", "Rize", "Sakarya", "Samsun", "Şanlıurfa", "Siirt", "Sinop", "Şırnak", "Sivas", "Tekirdağ", "Tokat", "Trabzon", "Tunceli", "Uşak", "Van", "Yalova", "Yozgat", "Zonguldak", "Diğer");

    const MAX_LENGTH_EMAIL = 40;
    const MIN_LENGTH_EMAIL = 8;
    const MAX_LENGTH_NAME = 40;
    const MIN_LENGTH_NAME = 5;
    const MAX_LENGTH_USERNAME = 20;
    const MIN_LENGTH_USERNAME = 3;
    const MAX_LENGTH_PASSWORD = 20;
    const MIN_LENGTH_PASSWORD = 6;
    const MIN_LENGTH_BIO = 0;
    const MAX_LENGTH_BIO = 5000;
    const MIN_AGE = 13;
    const MAX_AGE = 65;

    const BIOGRAPHY_PREVIEW_MAX_CHARACTERS = 20;

    /* Development */
    const VERSION_NO = "0.0.1";
    const MAINTENANCE_RESTRICTION = false;
    const MAINTENANCE_ALLOWED_IPS = "85.101.20.111";

}