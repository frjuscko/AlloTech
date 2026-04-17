<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/form.css">
        <script src="js/skilladd.js" defer></script>
        <title>Document</title>
    </head>
    <body>
        <main>
            <div class="menu">
                <a href><div class="photo_container logo"></div></a>
                <ul>
                    <li><a href="dashboard.html" class="btn_link fluide"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"><path
                                    d="M3 12C3 12.5523 3.44772 13 4 13H10C10.5523 13 11 12.5523 11 12V4C11 3.44772 10.5523 3 10 3H4C3.44772 3 3 3.44772 
                    3 4V12ZM3 20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V16C11 15.4477 10.5523 15 
                    10 15H4C3.44772 15 3 15.4477 3 16V20ZM13 20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 
                    20V12C21 11.4477 20.5523 11 20 11H14C13.4477 11 13 11.4477 13 12V20ZM14 3C13.4477 3 13 3.44772 13 
                    4V8C13 8.55228 13.4477 9 14 
                    9H20C20.5523 9 21 8.55228 21 8V4C21 3.44772 20.5523 3 20 3H14Z"></path></svg></a></li>
                    <li><a href="users.html" class="btn_link fluide"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"><path
                                    d="M12 14V22H4C4 17.5817 7.58172 14 12 14ZM18 21.5L15.0611 23.0451L15.6224 19.7725L13.2447 
                                    17.4549L16.5305 16.9775L18 14L19.4695 16.9775L22.7553 17.4549L20.3776 19.7725L20.9389 
                                    23.0451L18 21.5ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 
                                    10.315 15.315 13 12 13Z"></path></svg></a></li>
                    <li><a href="skills.html" class="btn_link fluide index"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"><path
                                    d="M18.001 20.0026V14.6693H20.001V22.0026H4.00098V14.6693H6.00098V20.0026H18.001ZM7.59977 14.7359L7.913 12.7566L16.75 14.456L16.6367 16.0421L7.59977 14.7359ZM8.79937 10.2041L9.53245 8.60463L17.5298 12.3367L16.7967 13.9362L8.79937 10.2041ZM11.0653 6.27208L12.1982 4.9392L18.9959 10.604L17.863 11.9368L11.0653 6.27208ZM15.3972 2.14014L20.6621 9.20443L19.2625 10.2707L13.9976 3.20645L15.3972 2.14014ZM7.33319 18.6679V16.6686H16.6634V18.6679H7.33319Z"></path></svg></a></li>
                    <li><a href="villes.html" class="btn_link fluide"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"><path
                                    d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H17V9H20C20.5523 9 21 9.44772 
                                    21 10V19ZM7 11V13H11V11H7ZM7 7V9H11V7H7Z"></path></svg></a></li>
                </ul>
                <a href>
                    <div class="photo_container user_photo">
                        <img src="imgs/user (1).png" alt>
                    </div>
                </a>
            </div>
            <div class="fenetre">
                <div class="bar">
                    <div class="search_bar">
                        <input type="text" class="search_input" required>
                        <button class="btn fluide"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"><path
                                    d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path></svg></button>
                    </div>
                    <div class="btns">
                        <button class="btn fluide"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"><path
                                    d="M12 18C8.68629 18 6 15.3137 6 12C6 8.68629 8.68629 6 12 6C15.3137 6 18 8.68629 18 12C18 15.3137 15.3137 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16ZM11 1H13V4H11V1ZM11 20H13V23H11V20ZM3.51472 4.92893L4.92893 3.51472L7.05025 5.63604L5.63604 7.05025L3.51472 4.92893ZM16.9497 18.364L18.364 16.9497L20.4853 19.0711L19.0711 20.4853L16.9497 18.364ZM19.0711 3.51472L20.4853 4.92893L18.364 7.05025L16.9497 5.63604L19.0711 3.51472ZM5.63604 16.9497L7.05025 18.364L4.92893 20.4853L3.51472 19.0711L5.63604 16.9497ZM23 11V13H20V11H23ZM4 11V13H1V11H4Z"></path></svg></button>
                        <button class="btn fluide"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"><path
                                    d="M22 20H2V18H3V11.0314C3 6.04348 7.02944 2 12 2C16.9706 2 21 6.04348 21 11.0314V18H22V20ZM9.5 21H14.5C14.5 22.3807 13.3807 23.5 12 23.5C10.6193 23.5 9.5 22.3807 9.5 21Z"></path></svg></button>
                        <div class="user">
                            <button class="photo_container user_photo">
                                <img src="imgs/user (1).png" alt>
                            </button>
                            <div class="names">
                                <p class="body bold">Frjus Cko</p>
                                <p class="details">Adm</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="interface">
                    <div class="left">
                        <div class="card tableau">
                            <p class="body bold gris_texte">Gestion des
                                compétences</p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Compétence</th>
                                        <th>Code</th>
                                        <th>Techniciens</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="user.html">
                                                <div class="user">
                                                    <div
                                                        class="photo_container photo">
                                                        <img
                                                            src="imgs/user (1).png"
                                                            alt>
                                                    </div>
                                                    <div class="names">
                                                        <p
                                                            class="body bold gris_texte">UI
                                                            Design</p>
                                                        <p
                                                            class="details gris_detail">Ajoutée
                                                            aujourd'hui</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="gris_detail body">UI</td>
                                        <td class="gris_detail body">0</td>
                                        <td><div class="actions">
                                                <a href><div
                                                        class="photo_container element">
                                                        <img
                                                            src="imgs/edit.png"
                                                            alt>
                                                    </div></a>
                                                <a href><div
                                                        class="photo_container element">
                                                        <img
                                                            src="imgs/gele.png"
                                                            alt>
                                                    </div></a>
                                            </div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="right">
                        <div class="indications">
                            <div class="indication">
                                <button disabled><img
                                        src="imgs/edit.png"
                                        alt></button>
                                <p>Modifier</p>
                            </div>
                            <div class="indication">
                                <button disabled><img
                                        src="imgs/gele.png"
                                        alt></button>
                                <p>Geler</p>
                            </div>
                        </div>
                    </div>
                    <a href="skilladd.html" class="float_btn"><svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="currentColor"><path
                                d="M2.5 7C2.5 9.48528 4.51472 11.5 7 11.5C9.48528 11.5 11.5 9.48528 11.5 7C11.5 4.51472 9.48528 2.5 7 2.5C4.51472 2.5 2.5 4.51472 2.5 7ZM2.5 17C2.5 19.4853 4.51472 21.5 7 21.5C9.48528 21.5 11.5 19.4853 11.5 17C11.5 14.5147 9.48528 12.5 7 12.5C4.51472 12.5 2.5 14.5147 2.5 17ZM12.5 17C12.5 19.4853 14.5147 21.5 17 21.5C19.4853 21.5 21.5 19.4853 21.5 17C21.5 14.5147 19.4853 12.5 17 12.5C14.5147 12.5 12.5 14.5147 12.5 17ZM16 11V8H13V6H16V3H18V6H21V8H18V11H16Z"></path></svg></a>
                    <div class="container">
                        <div class="form_box">
                            <div class="form_header">
                                <p class="body gris_texte bold">Ajouter une
                                    compétence</p>
                            </div>
                            <div class="form_body">
                                <form action="traitements/addSkill.php" method="post" enctype="multipart/form-data">
                                    <div class="photo_section">
                                        <div class="avatar_preview"
                                            id="avatarPreview">
                                            <div class="avatar_placeholder"
                                                id="placeholderIcon">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    fill="currentColor"><path
                                                        d="M14.4336 3C15.136 3 15.7869 3.36852 16.1484 3.9707L16.9209 5.25684C17.0113 5.40744 17.174 5.5 17.3496 5.5H19C20.6569 5.5 22 6.84315 22 8.5V18C22 19.6569 20.6569 21 19 21H5C3.34315 21 2 19.6569 2 18V8.5C2 6.84315 3.34315 5.5 5 5.5H6.65039C6.82602 5.5 6.98874 5.40744 7.0791 5.25684L7.85156 3.9707C8.21306 3.36852 8.86403 3 9.56641 3H14.4336ZM12 8.5C9.51472 8.5 7.5 10.5147 7.5 13C7.5 15.4853 9.51472 17.5 12 17.5C14.4853 17.5 16.5 15.4853 16.5 13C16.5 10.5147 14.4853 8.5 12 8.5ZM12 10.5C13.3807 10.5 14.5 11.6193 14.5 13C14.5 14.3807 13.3807 15.5 12 15.5C10.6193 15.5 9.5 14.3807 9.5 13C9.5 11.6193 10.6193 10.5 12 10.5Z"></path></svg>
                                            </div>
                                            <img id="profileImage" src="#"
                                                alt="aperçu"
                                                style="display: none; width:100%; height:100%; object-fit:cover;">
                                        </div>
                                        <input type="file" name="photo" id="photoInput"
                                            accept="image/jpeg, image/png, image/jpg, image/webp">
                                        <p class="body gris_detail">JPG, PNG, WEBP (max. 5
                                            Mo)</p>
                                    </div>
                                    <div class="input_box">
                                        <input type="text" name="code" required>
                                        <label for>Code</label>
                                    </div>
                                    <div class="input_box">
                                        <input type="text" name="libelle" required>
                                        <label for>Libelle</label>
                                    </div>
                                    <div class="btns">
                                        <a href="skills.php">Annuler</a>
                                        <button type="submit" name="submit">Ajouter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>