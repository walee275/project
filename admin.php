<?php require_once './database/connection.php' ?>

<?php

session_start();
// print_r($_SESSION['admin']);

if (isset($_SESSION['admin'])) {
} else {
    header('location: ./login.php');
}
?>




<!DOCTYPE html>
<html lang="en">


<?php require_once './includes/head.php' ?>




<body class="sb-nav-fixed" id="body">
    <?php require_once './includes/navbar.php'; ?>

    <div id="layoutSidenav" class="mb-auto">

        <?php require_once './includes/sidebar.php'; ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4" id="data-container">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col">
                            <a class="nav-link d-none btn btn-outline-primary " href="" type="button" data-bs-toggle="modal" data-bs-target="#addUser" id="add-users-btn">
                                Add Users
                            </a>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header" id="books-data-title">
                            <i class="fas fa-table me-1"></i>
                            Books Data
                        </div>
                        <div class="card-header  d-none" id="users-data-title">
                            <i class="fas fa-table me-1"></i>
                            Users Data
                        </div>
                        <div class="card-body shadow">
                            <div class="table-responsive">
                                <table id="books-table" class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Author</th>
                                            <th>Price</th>
                                            <th>Profile_Picture</th>
                                            <th>Publishing_date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-books" class="mb-5">


                                    </tbody>
                                </table>

                                <table id="users-table" class="table table-bordered d-none table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>E-mail</th>
                                            <th>created_at</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-users" class="mb-5">


                                    </tbody>
                                </table>
                                <table id="feedback-table" class="table table-bordered d-none">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>Book_id</th>
                                            <th>Comment</th>
                                            <th>Posted_At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-feedback" class="mb-5">


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>



    <?php require_once './includes/footer.php'; ?>


    <?php require_once './includes/modals.php'; ?>



    <?php require_once './includes/scripts.php'; ?>

    <script>
        // console.log($_SESSION['admin']);
        const errorAdd = document.getElementById('error');
        const successAdd = document.getElementById('success');

        const addBookForm = document.getElementById('add-book-form');

        addBookForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // alert('Hi Here');

            const book_nameElementAdd = document.getElementById('book-name-add');
            const Auth_nameElementAdd = document.getElementById('author-name-add');
            const book_descElementAdd = document.getElementById('book-desc-add');
            const book_priceElementAdd = document.getElementById('book-price-add');
            const publish_dateElementAdd = document.getElementById('publish-date-add');

            const BookValueAdd = book_nameElementAdd.value;
            const authorValueAdd = Auth_nameElementAdd.value;
            const descValueAdd = book_descElementAdd.value;
            const priceValueAdd = book_priceElementAdd.value;
            const publishdateValueAdd = publish_dateElementAdd.value;


            errorAdd.innerText = "";
            book_nameElementAdd.classList.remove('is-invalid');
            Auth_nameElementAdd.classList.remove('is-invalid');
            book_descElementAdd.classList.remove('is-invalid');
            book_priceElementAdd.classList.remove('is-invalid');
            publish_dateElementAdd.classList.remove('is-invalid');
            errorAdd.classList.remove('success');

            if (BookValueAdd == "" || BookValueAdd === undefined) {
                errorAdd.innerText = "please Provide your name!";
                book_nameElementAdd.classList.add('is-invalid');

            } else if (authorValueAdd == "" || authorValueAdd === undefined) {
                errorAdd.innerText = "please Provide your author Name!";
                Auth_nameElementAdd.classList.add('is-invalid');

            } else if (descValueAdd == "" || descValueAdd === undefined) {
                errorAdd.innerText = "please Provide your Description!";
                book_descElementAdd.classList.add('is-invalid');

            } else if (priceValueAdd == "" || priceValueAdd === undefined) {
                errorAdd.innerText = "please Provide your Price!";
                book_priceElementAdd.classList.add('is-invalid');

            } else if (publishdateValueAdd == "" || publishdateValueAdd === undefined) {
                errorAdd.innerText = "please Provide your Publish Date!";
                publish_dateElementAdd.classList.add('is-invalid');

            } else {
                // console.log('done');
                const data = {
                    bookname: BookValueAdd,
                    bookauthor: authorValueAdd,
                    bookdesc: descValueAdd,
                    bookprice: priceValueAdd,
                    bookpublishDate: publishdateValueAdd,
                    submit: 1
                }
                fetch('./add_book.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application.json'
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(result) {
                    // console.log(result);
                    if (result.errorName) {
                        errorAdd.innerText = result.errorName;
                        nameElementAdd.classList.add('is-invalid');
                    } else if (result.errorAuthor) {
                        errorAdd.innerText = result.errorAuthor;
                        emailElementAdd.classList.add('is-invalid');
                    } else if (result.errorDesc) {
                        successAdd.innerText = result.errorDesc;
                    } else if (result.errorPrice) {
                        errorAdd.innerText = result.errorPrice;
                    } else if (result.errorPublishDate) {
                        errorAdd.innerText = result.errorPublishDate;
                    } else if (result.errorQuery) {
                        errorAdd.innerText = result.errorQuery;
                    } else {

                        addBookForm.reset();
                        successAdd.innerText = result.success;
                    }
                })

            }
            showBooks();
        })

        showBooks();

        function showBooks() {

            fetch('./show_books.php', {
                headers: {
                    "Content-Type": "application.json"
                }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                // console.log(result);
                const tbody = document.getElementById('tbody-books');
                let row = "";
                result.forEach(function(value) {
                    row += `<tr><td>${value['title']}</td><td>${value['description']}</td><td>${value['Author']}</td><td>${value['price']}</td><td>${value['img']}</td><td>${value['publishing_date']}</td><td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBook" onclick="editBook(${value['id']})">Edit Book</button> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBook"onclick="deleteBook(${value['id']})">Delete Book</button></td></tr>`;
                });
                tbody.innerHTML = row;
            })

        }



        function editBook(id) {
            const errorEdit = document.getElementById('error-edit');
            const successEdit = document.getElementById('success-edit');

            const editBookForm = document.getElementById('edit-book-form');


            // alert('Hello me Here');


            data = {
                id: id,
                submit: 1
            }

            fetch('./show_single_book.php', {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application.json"
                }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                const book_nameElementedit = document.getElementById('book-name-edit');
                const Auth_nameElementedit = document.getElementById('author-name-edit');
                const book_descElementedit = document.getElementById('book-desc-edit');
                const book_priceElementedit = document.getElementById('book-price-edit');
                const publish_dateElementedit = document.getElementById('publish-date-edit');
                book_nameElementedit.setAttribute("value", result.title);
                Auth_nameElementedit.setAttribute("value", result.Author);
                book_descElementedit.value = result.description;
                book_priceElementedit.setAttribute("value", result.price);
                publish_dateElementedit.setAttribute("value", result.publishing_date);


                editBookForm.addEventListener("submit", function(e) {

                    e.preventDefault();
                    const book_nameElementedit = document.getElementById('book-name-edit');
                    const Auth_nameElementedit = document.getElementById('author-name-edit');
                    const book_descElementedit = document.getElementById('book-desc-edit');
                    const book_priceElementedit = document.getElementById('book-price-edit');
                    const publish_dateElementedit = document.getElementById('publish-date-edit');
                    book_nameValueEdit = book_nameElementedit.value;
                    book_AuthValueEdit = Auth_nameElementedit.value;
                    book_descValueEdit = book_descElementedit.value;
                    book_priceValueEdit = book_priceElementedit.value;
                    book_dateValueEdit = publish_dateElementedit.value;


                    errorEdit.innerText = successEdit.innerText = "";



                    book_nameElementedit.classList.remove('is-invalid');
                    Auth_nameElementedit.classList.remove('is-invalid');
                    book_descElementedit.classList.remove('is-invalid');
                    book_priceElementedit.classList.remove('is-invalid');
                    publish_dateElementedit.classList.remove('is-invalid');

                    if (book_nameValueEdit == "" || book_nameValueEdit === undefined) {
                        errorEdit.innerText = "please Provide your name!";
                        book_nameElementedit.classList.add('is-invalid');

                    } else if (book_AuthValueEdit == "" || book_AuthValueEdit === undefined) {
                        errorEdit.innerText = "please Provide your author Name!";
                        Auth_nameElementedit.classList.add('is-invalid');

                    } else if (book_descValueEdit == "" || book_descValueEdit === undefined) {
                        errorEdit.innerText = "please Provide your Description!";
                        book_descElementedit.classList.add('is-invalid');

                    } else if (book_priceValueEdit == "" || book_priceValueEdit === undefined) {
                        errorEdit.innerText = "please Provide your Price!";
                        book_priceElementedit.classList.add('is-invalid');

                    } else if (book_dateValueEdit == "" || book_dateValueEdit === undefined) {
                        errorEdit.innerText = "please Provide your Publish Date!";
                        publish_dateElementedit.classList.add('is-invalid');

                    } else {
                        const data = {
                            booknameedit: book_nameValueEdit,
                            bookauthoredit: book_AuthValueEdit,
                            bookdescedit: book_descValueEdit,
                            bookpriceedit: book_priceValueEdit,
                            bookpublishDateedit: book_dateValueEdit,
                            id: id,
                            submit: 1
                        }

                        fetch('./edit_books.php', {
                            method: 'POST',
                            body: JSON.stringify(data),
                            headers: {
                                'Content-Type': 'application.json'
                            }
                        }).then(function(response) {
                            return response.json();
                        }).then(function(result) {
                            // console.log(result);
                            if (result.errorNameedit) {
                                errorEdit.innerText = result.errorName;
                                nameElementAdd.classList.add('is-invalid');
                            } else if (result.errorAuthoredit) {
                                errorEdit.innerText = result.errorAuthor;
                                emailElementAdd.classList.add('is-invalid');
                            } else if (result.errorDescedit) {
                                errorEdit.innerText = result.errorDesc;
                            } else if (result.errorPriceedit) {
                                errorEdit.innerText = result.errorPrice;
                            } else if (result.errorPublishDateedit) {
                                errorEdit.innerText = result.errorPublishDate;
                            } else if (result.errorQueryedit) {
                                errorEdit.innerText = result.errorQuery;
                            } else {
                                showBooks();
                                editBookForm.reset();
                                successEdit.innerText = result.success;
                            }
                        })

                    }

                    // console.log(publish_dateElementedit);

                })
                // 
            })
        }



        function deleteBook(id) {
            const errorDelete = document.getElementById('error-delete');
            const successDelete = document.getElementById('success-delete');

            const deleteUserForm = document.getElementById('delete-book-form');
            deleteUserForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // console.log(deleteUserForm);


                const data = {
                    id: id,
                    submit: 1
                }
                fetch('./delete_book.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application.json"
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(result) {
                    if (result.success) {
                        successDelete.innerText = result.success;
                        showBooks();
                    } else {
                        errorDelete.innerText = result.error;

                    }
                })
            })
        }

        const errorAddUser = document.getElementById('error-add-user');
        const successAddUser = document.getElementById('success-add-user');
        const addUserForm = document.getElementById('add-user-form');

        addUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // alert('Hi Here');

            const nameElementAdd = document.getElementById('user-name-add');
            const emailElementAdd = document.getElementById('email-add');
            const passwordElementAdd = document.getElementById('password-add');
            const nameValueAdd = nameElementAdd.value;
            const emailValueAdd = emailElementAdd.value;
            const passwordValueAdd = passwordElementAdd.value;


            errorAddUser.innerText = errorAdd.innerText = "";
            nameElementAdd.classList.remove('is-invalid');
            emailElementAdd.classList.remove('is-invalid');
            passwordElementAdd.classList.remove('is-invalid');


            if (nameValueAdd == "" || nameValueAdd === undefined) {
                errorAddUser.innerText = "please Provide your name!";
                nameElementAdd.classList.add('is-invalid');

            } else if (emailValueAdd == "" || emailValueAdd === undefined) {
                errorAddUser.innerText = "please Provide your email!";
                emailElementAdd.classList.add('is-invalid');
            } else if (passwordValueAdd == "" || passwordValueAdd === undefined) {
                errorAddUser.innerText = "please Provide your password!";
                passwordElementAdd.classList.add('is-invalid');
            } else {
                // console.log('done');
                const data = {
                    name: nameValueAdd,
                    email: emailValueAdd,
                    password: passwordValueAdd,
                    submit: 1
                }
                fetch('./add_user.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application.json'
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(result) {
                    if (result.emptyName) {
                        errorAdd.innerText = result.emptyName;
                        nameElementAdd.classList.add('is-invalid');
                    } else if (result.emptyEmail) {
                        errorAdd.innerText = result.emptyEmail;
                        emailElementAdd.classList.add('is-invalid');
                    } else if (result.emptyPassword) {
                        errorAdd.innerText = result.emptyEmail;
                        passwordElementAdd.classList.add('is-invalid');
                    } else if (result.success) {
                        successAdd.innerText = result.success;
                        addUserForm.reset();
                        // showUsers()
                    } else if (result.failed) {
                        errorAdd.innerText = result.failed;
                    }
                })
                // console.log(data);
            }

        })



        function showUsers() {
            const bookTable = document.getElementById('books-table');
            const usersTable = document.getElementById('users-table');
            const feedbackTable = document.getElementById('feedback-table');

            const addUsersBtn = document.getElementById('add-users-btn');
            const booksTitle = document.getElementById('books-data-title');
            const usersTitle = document.getElementById('users-data-title');

            bookTable.classList.add('d-none');
            addUsersBtn.classList.remove('d-none');
            usersTable.classList.remove('d-none');
            booksTitle.classList.add('d-none');
            usersTitle.classList.remove('d-none');
            feedbackTable.classList.add('d-none');
            // console.log(usersTitle);


            fetch('./show_users.php', {
                headers: {
                    "Content-Type": "application.json"
                }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                // console.log(result);
                const tbody = document.getElementById('tbody-users');
                let row = "";
                result.forEach(function(value) {
                    row += `<tr><td>${value['name']}</td><td>${value['email']}</td><td>${value['created_at']}</td><td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUser" onclick="editUser(${value['id']})">Edit User</button> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUser"onclick="deleteUser(${value['id']})">Delete User</button></td></tr>`;
                });
                tbody.innerHTML = row;
            })
        }


        showUsersBtn = document.getElementById('users-data');
        showUsersBtn.addEventListener("click", function(e) {
            e.preventDefault();

            showUsers();
        })

        function editUser(id) {
            const errorEdit = document.getElementById('error-user-edit');
            const successEdit = document.getElementById('success-user-edit');

            const editUserForm = document.getElementById('edit-user-form');


            // alert('Hello me Here');


            data = {
                id: id,
                submit: 1
            }

            fetch('./show_single_user.php', {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application.json"
                }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                const nameElementedit = document.getElementById('name-edit');
                const emailElementedit = document.getElementById('email-edit');
                nameElementedit.setAttribute("value", result.name);
                emailElementedit.setAttribute("value", result.email);
                // console.log(result);
            })


            editUserForm.addEventListener("submit", function(e) {
                e.preventDefault();

                const nameElementEdit = document.getElementById('name-edit');
                const emailElementEdit = document.getElementById('email-edit');

                let nameValueEdit = nameElementEdit.value;
                let emailValueEdit = emailElementEdit.value;

                errorEdit.innerText = "";
                errorEdit.innerText = "";
                nameElementEdit.classList.remove('is-invalid');
                emailElementEdit.classList.remove('is-invalid');


                if (nameValueEdit == "" || nameValueEdit === undefined) {
                    errorEdit.innerText = "Please enter your name!";
                    nameElementEdit.classList.add('is-invalid');
                } else if (emailValueEdit == "" || emailValueEdit === undefined) {
                    errorEdit.innerText = "Please enter your email!";
                    emailElementEdit.classList.add('is-invalid');
                } else {

                    data = {
                        name: nameValueEdit,
                        email: emailValueEdit,
                        id: id,
                        submit: 1
                    }
                    fetch('./edit_user.php', {
                        method: "POST",
                        body: JSON.stringify(data),
                        headers: {
                            "Content-Type": "application.json"
                        }

                    }).then(function(response) {
                        return response.json();
                    }).then(function(result) {
                        if (result.emptyName) {
                            errorEdit.innerText = result.emptyName;
                        } else if (result.emptyEmail) {
                            errorEdit.innerText = result.emptyEmail;
                        } else if (result.error) {
                            errorEdit.innerText = result.error;
                        } else if (result.success) {
                            successEdit.innerText = result.success;
                            showUsers();
                        } else {
                            errorEdit.innerText = result.error; //show error if query doesn't works;
                        }
                    })



                }



            })
        }

        function deleteUser(id) {
            const errorDelete = document.getElementById('error-user-delete');
            const successDelete = document.getElementById('success-user-delete');

            const deleteUserForm = document.getElementById('delete-user-form');
            deleteUserForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // console.log(deleteUserForm);


                const data = {
                    id: id,
                    submit: 1
                }
                fetch('./delete_user.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application.json"
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(result) {
                    if (result.success) {
                        successDelete.innerText = result.success;
                        showUsers();
                    } else {
                        errorDelete.innerText = result.error;

                    }
                })

                // showUsers();

                // const tbody = document.getElementById('tbody');
                // 	let row  = "";
                // 	result.forEach(function(value){
                // 		row += `<tr><td>${value['name']}</td><td>${value['email']}</td><td>${value['Created_at']}</td><td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUser" onclick="editUser(${value['id']})">Edit User</button> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUser"onclick="deleteUser(${value['id']})">Delete User</button></td></tr>`;
                // 	});
                // 	tbody.innerHTML += row;
            })
        }

        function showUsersFeedback() {
            const bookTable = document.getElementById('books-table');

            const usersTable = document.getElementById('users-table');

            const feedbackTable = document.getElementById('feedback-table');

            const addUsersBtn = document.getElementById('add-users-btn');
            const booksTitle = document.getElementById('books-data-title');
            const usersTitle = document.getElementById('users-data-title');

            bookTable.classList.add('d-none');
            addUsersBtn.classList.add('d-none');
            usersTable.classList.add('d-none');

            feedbackTable.classList.remove('d-none');

            booksTitle.classList.add('d-none');
            usersTitle.classList.add('d-none');

            fetch('./show_comments.php', {
                headers: {
                    "Content-Type": "application.json"
                }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                console.log(result);
                const tbody = document.getElementById('tbody-feedback');
                let row = "";
                result.forEach(function(value) {
                    row += `<tr><td>${value['user_name']}</td><td>${value['book_id']}</td><td>${value['comment_text']}</td><td>${value['created_at']}</td><td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserFeedback" onclick="deleteUsersFeedback(${value['id']})">Delete User Feedback</button></tr>`;
                });
                tbody.innerHTML = row;

            });
        }
            const showUsersFeedbackBtn = document.getElementById('feedback-data');
            // console.log(showUsersFeedbackBtn);
            showUsersFeedbackBtn.addEventListener("click", function(e) {
                e.preventDefault();

                showUsersFeedback();
            })


            function deleteUsersFeedback(id) {
            const errorDelete = document.getElementById('error-feedback-delete');
            const successDelete = document.getElementById('success-feedback-delete');

            const deleteUserFeedbackForm = document.getElementById('delete-feedback-form');
            deleteUserFeedbackForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // console.log(deleteUserForm);


                const data = {
                    id: id,
                    submit: 1
                }
                fetch('./delete_feedback.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application.json"
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(result) {
                    if (result.success) {
                        showUsersFeedback();
                        successDelete.innerText = result.success;
                    } else {
                        errorDelete.innerText = result.error;

                    }
                })

                // showUsers();

                // const tbody = document.getElementById('tbody');
                // 	let row  = "";
                // 	result.forEach(function(value){
                // 		row += `<tr><td>${value['name']}</td><td>${value['email']}</td><td>${value['Created_at']}</td><td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUser" onclick="editUser(${value['id']})">Edit User</button> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUser"onclick="deleteUser(${value['id']})">Delete User</button></td></tr>`;
                // 	});
                // 	tbody.innerHTML += row;
            })
        }

            // }
    </script>

</body>

</html>