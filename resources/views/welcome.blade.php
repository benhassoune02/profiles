<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    body {
    font-family: 'Arial', sans-serif;
    margin-top: 150px;
    padding: 0;
    line-height: 1.6;

}

.landing-container {
text-align: center;
padding: 20px;
}

.landing-container h1 {
font-size: 2.5em;
margin-bottom: 20px;
}

.landing-container p {
color: #4d4d4d;
font-size: 1.2em;
margin-bottom: 40px;
}

.features {
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 20px;
margin-bottom: 40px;
}

.feature-item {
background: #d9d9d9;
padding: 20px;
border-radius: 8px;
}

.feature-item h2 {
font-size: 1.5em;
color: #333;
}

.feature-item p {
font-size: 1em;
}

.cta-button {
display: inline-block;
background: #4f4f4f;
color: rgb(255, 255, 255);
padding: 10px 20px;
border-radius: 5px;
text-decoration: none;
font-size: 1.2em;
transition: background-color 1.1s;
}

.cta-button:hover {
    background-color: #ffffff; 
    color: #000000;
}

.how-it-works {
    background: #f3f3f3;
    padding: 40px;
    margin-top: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.how-it-works h2 {
    font-size: 2.6em;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.how-it-works-step {
    background: rgb(200, 200, 200);
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.how-it-works-step p {
    font-size: 1em;
    color: #000000;
    line-height: 1.6;
}

.step-title {
    font-size: 1.2em;
    color: #5f5d5d;
    margin-bottom: 10px;
    font-weight: bold;
    display: block; 
}

.step-description {
    margin-left: 20px; 
}

.cta-button-container {
    text-align: center; 
    margin-top: 20px; 
}
.feature-item svg {
    fill: #000000; 
    width: 35px; 
    height: 35px; 
    margin-bottom: 10px;
}


.about-section img {
    max-width: 100%;
    height: 400px;
    width: 700px;
    border-radius: 8px;
    margin-top: 105px;
}
.about-section {
    background: #f9f8f8;
    padding: 40px;
    text-align: center;
    border-radius: 32px;
    box-shadow: 20px 70px 60px 70px rgba(0, 0, 0, 0.1);
    margin-top: 40px;
}

.about-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}

.about-section h2 {
    color: #000000;
    font-size: 2em;
    margin-bottom: 20px;
}

.about-section p {
    color: #787878;
    font-size: 1.2em;
    line-height: 1.6;
}

.contact-form-container {
    margin-top: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background: #ffffff;
    padding: 20px; 
    border-radius: 32px;
    box-shadow: 20px 70px 60px 70px rgba(0, 0, 0, 0.1);

}

.contact-form {
    max-width: 400px;
    width: 100%;
}

.contact-form label {
    display: block;
    margin-bottom: 5px;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #777575;
    border-radius: 12px;
}

.contact-form button {
    background-color: #e2dfdf;
    color: #3d3b3b;
    font-size: 18px;
    padding: 15px 45px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif
}

.contact-form button:hover {
    background-color: #5a5a5a;
    transition: background-color 0.9s ease; 
    color: #ffffff;
}
.success-message {
    background-color: #4CAF50; 
    color: white; 
    padding: 15px; 
    margin-bottom: 20px; 
    border-radius: 5px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: inline-block; 
}

.success-message svg {
    vertical-align: middle; 
    margin-right: 8px; 
}
.footer-menu {
    width: 100%;
    background-color: #333; 
    padding: 20px 0;
    box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
    color: #000000; 
}

.footer-menu .navbar-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.footer-menu .navbar-menu {
    list-style: none;
    display: flex;
    padding: 0;
    margin: 0; 
    justify-content: center; 
}

.footer-menu .navbar-menu li {
    padding: 0 20px; 
}

.footer-menu .navbar-menu li a {
    text-decoration: none;
    color: #757474; 
    transition: color 0.3s ease-in-out;
}

.footer-menu .navbar-menu li a:hover {
    color: #ddd;
}

.footer-menu .navbar-menu li.active a {
    font-weight: bold;
    border-bottom: 2px solid #fff;
}

</style>
</head>
<body>
    @include('client.navbar')
    <div class="landing-container" style="margin-top: 90px;">
        @if(session('success'))
            <div class="success-message">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        <h1>Welcome to Our Website UNLOCKINFOS !</h1>
        <p>Here you can find valuable information tailored to your needs. Browse, explore, and buy the information that helps you make better decisions.</p>
        
        <div style="background:#acabab; padding: 34px; margin-left:-20px; margin-right:-20px;">
            <div class="features">
                <div class="feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                    <h2>Comprehensive Profiles</h2>
                    <p>Dive into our extensive database of profiles, featuring detailed and accurate information for informed decision-making.</p>
                </div>
                <div class="feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM112 192H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                    <h2>Customized Selection</h2>
                    <p>Tailor your information package to suit your specific needs, selecting only the profiles most relevant to your objectives.</p>
                </div>
                <div class="feature-item">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/></svg>
                    <h2>Real-Time Updates</h2>
                    <p>Stay ahead with the latest information, as our profiles are continuously updated with the most current data.</p>
                </div>
            </div>
            <div class="cta-button-container"> 
                <a href="{{ route('client_profiles') }}" class="cta-button">Buy Informations Now !</a>
            </div>
        </div>        
        <div class="about-section" style="margin-top: 25px; display: flex;">
            <img src="https://www.kbcrawl.com/wp-content/uploads/2018/09/diffusion-de-linformation.png" alt="About Us" />
            <div>
                <h2 >ABOUT US</h2>
                <p>Welcome to UNLOCKINFOS, where we strive to provide valuable information tailored to your unique needs. Our mission is to empower you with accurate and comprehensive profiles, enabling you to make informed decisions.<br> Our mission is to simplify your decision-making process by offering a customized selection of profiles that match your specific objectives. </p>
            </div>
        </div>
        <div class="how-it-works">
            <h2>HOW IT WORKS ?</h2>
            <div class="how-it-works-step">
                <span class="step-title"> Browse Profiles</span>
                <p class="step-description">Use our advanced search tools to find the perfect profile that meets your criteria.</p>
            </div>
            <div class="how-it-works-step">
                <span class="step-title"> Choose Your Plan</span>
                <p class="step-description">Select a payment plan that suits your needs. We offer single profile purchases or collection of profiles.</p>
            </div>
            <div class="how-it-works-step">
                <span class="step-title"> Access Detailed Informations</span>
                <p class="step-description">Once your purchase is complete, you’ll have full access to the profile’s detailed informations.</p>
            </div>
        </div>
        <div class="contact-form-container">
            <h2 style="margin-right: 6px;">CONTACT US !</h2>
            <form action="{{ route('client_contact') }}" method="post" class="contact-form" style="background-color: #b7b6b6; padding: 75px; border-radius: 13px;">
                @csrf
                <label for="name">First Name:</label>
                <input type="text" name="name" required>
        
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" required>
        
                <label for="email">Email:</label>
                <input type="email" name="email" required>
        
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" required>
        
                <label for="address">Address:</label>
                <input type="text" name="address" required>
        
                <label for="message">Message:</label>
                <textarea name="message" required style="height: 220px;"></textarea>
        
                <button type="submit">SEND</button>
            </form>
        </div>
    </div>
    <footer class="footer-menu">
        <div class="navbar-container">
            <ul class="navbar-menu">
                <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">HOME</a></li>
                <li class="{{ Request::is('client/client-profiles') ? 'active' : '' }}"><a href="{{ route('client_profiles') }}">PROFILES</a></li>
                <li class="{{ Request::is('client/cart') ? 'active' : '' }}"><a href="{{ route('cartview') }}">CART</a></li>
                <li class="{{ Request::is('client/edit_client_profile') ? 'active' : '' }}"><a href="{{ route('edit_profile') }}">ACCOUNT</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>