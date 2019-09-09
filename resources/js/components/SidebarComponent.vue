<template>
    <div class="sidenav">
        <router-link :to="{ name: 'home' }">Home</router-link>
<!--        <a class="active" href="#home">Home</a>-->
<!--        <a href="#news">News</a>-->
<!--        <a href="#contact">Contact</a>-->
        <router-link :to="{ name: 'clients' }">Clients</router-link>
        <router-link :to="{ name: 'countries' }">Countries</router-link>
        <router-link :to="{ name: 'cities' }">Cities</router-link>
        <router-link :to="{ name: 'contact-types' }">Contact Types</router-link>
        <router-link :to="{ name: 'industries' }">Industries</router-link>
    </div>
</template>

<style>
    /* The sidebar menu */
    .sidenav {
        height: 100%; /* Full-height: remove this if you want "auto" height */
        width: 200px; /* Set the width of the sidebar */
        position: fixed; /* Fixed Sidebar (stay in place on scroll) */
        z-index: 1; /* Stay on top */
        top: 0; /* Stay at the top */
        left: 0;
        background-color: #111; /* Black */
        overflow-x: hidden; /* Disable horizontal scroll */
        padding-top: 20px;
    }

    /* The navigation menu links */
    .sidenav a {
        padding: 15px 8px 15px 20px;
        text-decoration: none;
        font-size: 18px;
        color: #818181;
        display: block;
    }

    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover {
        color: #f1f1f1;
        background-color: #333;
    }

    /* Style page content */
    #main {
        padding-top: 20px;
        margin-left: 20px;
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }
</style>
