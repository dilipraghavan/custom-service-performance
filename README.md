# Custom Service Performance Plugin

A WordPress plugin to create and display custom services with a performant transient caching mechanism. This project serves as a portfolio piece to demonstrate proficiency in WordPress plugin development, custom post types, and caching best practices.

---

### Features

- **Services Custom Post Type**: A custom post type for easily managing service content in the WordPress dashboard.
- **Service Details Meta Box**: A custom meta box on the service edit screen for adding an icon URL, service name, and a description.
- **Shortcode `[csp_services]`**: A front-end shortcode that displays all services in a grid format, pulling data from the custom post type.
- **Transient Caching**: The shortcode's output is stored in a transient cache for 12 hours. The cache is automatically cleared whenever a service is saved or updated.
- **Cache Settings Page**: A custom settings page in the WordPress dashboard with a button to manually clear the transient cache.

---

### Installation

There are two methods for installation depending on whether you are an end-user or a developer.

#### For End-Users (Packaged Plugin)

To install a ready-to-use version of the plugin, download the latest release from the [Releases page](https://github.com/dilipraghavan/custom-service-performance/releases). This version is pre-packaged with all dependencies included.

1.  Download the `.zip` file from the latest release.
2.  In the WordPress dashboard, go to **Plugins** > **Add New**.
3.  Click **Upload Plugin**, select the downloaded `.zip` file, and click **Install Now**.
4.  After installation, click **Activate Plugin**.

#### For Developers (with Composer)

This is the recommended method for developers who want to work with the source code or contribute to the plugin.

1.  **Clone the Repository:** Clone the plugin from GitHub to your local machine using Git.
    ```bash
    git clone [https://github.com/dilipraghavan/custom-service-performance.git](https://github.com/dilipraghavan/custom-service-performance.git)
    ```
2.  **Install Dependencies:** Navigate into the cloned folder from your command line and run Composer to install the required libraries.
    ```bash
    cd custom-service-performance
    composer install
    ```
3.  **Create ZIP Archive:** Create a `.zip` archive of the entire `custom-service-performance` folder. This zip file now contains all the necessary plugin files, including the `vendor` directory.
4.  **Upload to WordPress:** In the WordPress dashboard, go to **Plugins** > **Add New**, click **Upload Plugin**, and select the `.zip` file you just created.
5.  **Activate Plugin:** After installation, click **Activate Plugin**.

---

### Usage

1.  **Add Services**: Navigate to the new **Services** menu item in the dashboard to create and edit your services.
2.  **Display on Site**: To display your services on the front end, simply add the shortcode `[csp_services]` to any page, post, or widget where you want them to appear.
3.  **Clear Cache**: If you need to manually clear the cache, go to **Settings** > **Custom Services Settings** and click the **Clear Cache** button.

---

### Contributing

We welcome contributions! If you have a bug fix or a new feature, please follow these steps:

1.  Fork the repository.
2.  Create a new branch for your feature or bug fix.
3.  Commit your changes following a clear and concise commit message format.
4.  Push your branch to your forked repository.
5.  Submit a pull request.
