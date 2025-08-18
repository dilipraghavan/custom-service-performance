# Custom Service Performance Plugin

A WordPress plugin to create and display custom services with a performant transient caching mechanism. This project serves as a portfolio piece to demonstrate proficiency in WordPress plugin development, custom post types, and caching best practices.

***

### Features

- **Services Custom Post Type**: A custom post type for easily managing service content in the WordPress dashboard.
- **Service Details Meta Box**: A custom meta box on the service edit screen for adding an icon URL, service name, and a description.
- **Shortcode `[csp_services]`**: A front-end shortcode that displays all services in a grid format, pulling data from the custom post type.
- **Transient Caching**: The shortcode's output is stored in a transient cache for 12 hours. The cache is automatically cleared whenever a service is saved or updated.
- **Cache Settings Page**: A custom settings page in the WordPress dashboard with a button to manually clear the transient cache.

***

### Installation

1. Download the plugin files as a `.zip` archive from this repository.
2. In the WordPress dashboard, go to **Plugins** > **Add New**.
3. Click **Upload Plugin**, select the downloaded `.zip` file, and click **Install Now**.
4. After installation, click **Activate Plugin**.

***

### Usage

1. **Add Services**: Navigate to the new **Services** menu item in the dashboard to create and edit your services.
2. **Display on Site**: To display your services on the front end, simply add the shortcode `[csp_services]` to any page, post, or widget where you want them to appear.
3. **Clear Cache**: If you need to manually clear the cache, go to **Settings** > **Custom Services Settings** and click the **Clear Cache** button.
