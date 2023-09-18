# Orders manager with PHP

Order management solution, for retail stores. My first Full Stack app in 2019 🤓.

Also, you can check out my second Full Stack app: [orders-manager-java](https://github.com/jhordyess/orders-manager-java).

## Description

This project is a web application for managing orders, customers, products, and suppliers. It was developed for a retail store.

The project was initially created using Sublime Text and XAMPP in 2019 and later transitioned to VSCode in 2022. It's primarily built with Vanilla PHP version 7 and utilizes a MySQL 5.7 database, while Apache serves as the server. Deployment can be easily accomplished using Docker.

For more information on deploying PHP applications in Docker, you can refer to this tutorial: [dockerizing-a-php-application](https://semaphoreci.com/community/tutorials/dockerizing-a-php-application).

Some of the features are:

- Manage customers, products, suppliers, and orders.
- Generate PDF invoices and order itineraries.
- Review customer and product details.
- Review order status: orders, canceled, shipped, payment debts.

### Technologies Used

- JS Libraries: [jQuery](https://jquery.com/), [ChartJS](https://www.chartjs.org/), [Datatables](https://datatables.net/)
- Programming Language: [PHP](https://www.php.net/)
- CSS Libraries: [Bootstrap](https://getbootstrap.com/)
- Icon library: [Font Awesome](https://fontawesome.com/)
- Database: [MySQL](https://www.mysql.com/)
- Typesetting system: [Latex](https://www.latex-project.org/)
- Server: [Apache](https://httpd.apache.org/)
- Dev Environment: [VSCode](https://code.visualstudio.com/) with [dev containers](https://code.visualstudio.com/docs/remote/containers) in [Zorin OS](https://zorinos.com/)

### Screenshots

![Dashboard](https://res.cloudinary.com/jhordyess/image/upload/v1660836126/orders-manager/php/Dashboard.png)
![New order](https://res.cloudinary.com/jhordyess/image/upload/v1662128724/orders-manager/php/new_order.png)
![Order list](https://res.cloudinary.com/jhordyess/image/upload/v1662128724/orders-manager/php/order_list.png)
![Invoice with LaTeX](https://res.cloudinary.com/jhordyess/image/upload/v1669155002/orders-manager/php/order_invoice.png)
![DDBB with phpMyAdmin Designer](https://res.cloudinary.com/jhordyess/image/upload/v1662128383/orders-manager/php/DDBB.png)

## How to use for development

You can use the VSCode dev containers to run the project in a containerized environment.

You need to have installed [Docker](https://www.docker.com/) and [VSCode](https://code.visualstudio.com/), and the [Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) extension.

1. Clone this repository

```bash
git clone git@github.com:jhordyess/orders-manager-php.git
```

2. Open the project in VSCode

```bash
code orders-manager-php
```

3. Create a `.env` file in the root folder by copying the example from the [`.env.example`](./.env.example) file.

4. Open the integrated terminal (Ctrl+Shift+`) and run the following command:

```bash
docker compose -f docker-compose.dev.yml up -d
```

5. Open the command palette (Ctrl+Shift+P) and select the option `Dev Containers: Open folder in Container`.

6. Select the folder `php-app` and wait for the container to be built.

7. Open the integrated terminal (Ctrl+Shift+`) and run the following command:

```bash
apache2-foreground
```

9. Open the browser and visit <http://localhost:80/>

## How to use for production

To run the project in production mode, remember to create the `.env` file in the root folder by copying the example from the [`.env.example`](./.env.example) file.

Then, run the following command:

```bash
docker compose -f docker-compose.prod.yml up -d
```

To stop or remove the containers, use the following commands:

```bash
docker compose -f docker-compose.prod.yml down
```

Take note that this production configuration is just for testing purposes, and maybe need some changes to be used in a real production environment.

## To-Do

- The project was originally created in Spanish, and still needs to be translated.
- Migrate to PHP 8.
- Migrate MySQL 5.7 to 8.0(LTS).
- Unnecessary event field for order registry.
- Fix database backup download.
- Fix login, users and roles.

## Contribution

If you would like to contribute to the project, open an issue or make a pull request on the repository.

## License

© 2022 [Jhordyess](https://github.com/jhordyess). Under the [MIT](https://choosealicense.com/licenses/mit/) license. See the [LICENSE](./LICENSE) file for more details.

---

Made with 💪 by [Jhordyess](https://www.jhordyess.com/)
