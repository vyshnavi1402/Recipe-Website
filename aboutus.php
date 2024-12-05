<?php
// Start the PHP session to handle any session-based information (optional)
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Culinary Canvas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: skyblue;
            color: #333;
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 0;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 3em;
            color: black;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        header p {
            font-size: 1.2em;
            color: #666;
        }

        /* Section Styling */
        .about-section {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 50px;
        }

        .about-text {
            width: 60%;
        }

        .about-text h2 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
            transition: color 0.3s;
        }

        .about-text p {
            font-size: 1.1em;
            line-height: 1.8;
            color: #777;
        }

        .about-text:hover h2 {
            color: #4CAF50;
        }

        .about-image {
            width: 35%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: scale(1);
            transition: transform 0.5s ease;
        }

        .about-image img {
            width: 100%;
            height: 250px;
        }

        .about-image:hover {
            transform: scale(1.05);
        }

        /* Mission Section */
        .mission-section {
            background-color: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .mission-section h2 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: black;
        }

        .mission-section p {
            font-size: 1.2em;
            line-height: 1.8;
            text-align: center;
            color: #555;
        }

        /* Timeline Section */
        .timeline-section {
            margin-top: 50px;
            padding: 50px 0;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .timeline-section h2 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
            color: black;
        }

        .timeline {
            list-style: none;
            padding-left: 0;
        }

        .timeline li {
            position: relative;
            padding-left: 40px;
            margin-bottom: 20px;
        }

        .timeline li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 12px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: ;
        }

        .timeline p {
            font-size: 1.1em;
            color: black;
        }

        /* Founder Quote Section */
        .quote-section {
            margin-top: 50px;
            text-align: center;
            background-color: #f1f1f1;
            padding: 50px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .quote-section p {
            font-size: 1.5em;
            font-style: italic;
            color: #333;
        }

        .quote-section cite {
            font-size: 1.2em;
            color: brown;
            font-weight: bold;
        }

        /* Team Member Section */
        .team-member {
            text-align: center;
            margin-bottom: 50px;
        }

        .team-member img {

            border-radius: 70%;
            width: 180px;
            height: 180px;
            object-fit: cover;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .team-member h3 {
            font-size: 2em;
            color: brown;
            margin-bottom: 2px;
        }

        .team-member p {
            font-size: 1.1em;
            color: brown;
        }

        /* Button Styling */
        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2em;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>Culinary Canvas</h1>
            <p>Where flavor meets creativity. Welcome to our culinary world.</p>
        </header>

        <!-- About Section -->
        <div class="about-section">
            <div class="about-text">
                <h2>Who We Are</h2>
                <p>At <strong>Culinary Canvas</strong>, we believe cooking is an art, and every recipe is a masterpiece. Our mission is to provide a platform where food lovers can discover and share delightful recipes, experiment with diverse cuisines, and create memories around the table. Whether you are an aspiring home chef or a seasoned professional, we aim to inspire creativity in every dish.</p>
            </div>
            <div class="about-image">
                <img src="aboutus.jpg" alt="About Us">
            </div>
        </div>

        <!-- Mission Section -->
        <div class="mission-section">
            <h2>Our Mission</h2>
            <p>Our goal is to provide easy-to-follow recipes that elevate your cooking journey. From classic dishes to modern twists, we are here to spark creativity in your kitchen, help you discover new flavors, and inspire you to cook with passion.</p>
        </div>

        <!-- Timeline Section -->
        <div class="timeline-section">
            <h2>Our Journey</h2>
            <ul class="timeline">
                <li>
                    <p><strong>2021:</strong> Culinary Canvas was founded with the vision to create a platform for creative chefs worldwide.</p>
                </li>
                <li>
                    <p><strong>2022:</strong> We launched our first digital recipe book, showcasing some of our favorite dishes.</p>
                </li>
                <li>
                    <p><strong>2023:</strong> Expanded into interactive video tutorials, helping home cooks step-by-step.</p>
                </li>
            </ul>
        </div>

        <!-- Founder Quote Section -->
        <div class="quote-section">
            <p>"Cooking is not just about following a recipe, it's about expressing your creativity and sharing love through food." - <cite>Vyshnavi Gangavaram,Founder</cite>
        </div>

        <!-- Team Member Section -->
        <div class="team-member">
            <img src="vyshnavi.jfif" alt="John Doe">
            <h3>Vyshnavi Gangavaram</h3>
            <p>Founder </p>
                    </div>

            </div>
</body>

</html>
navi