# JobRunner Command

This `artisan` command allows you to execute methods from jobs in your Laravel application. It enables you to run job methods in the background with optional parameters passed directly from the command line.

## Installation

1. Ensure your Laravel application is set up and running.
2. Add the `JobRunCommand` class to the `app/Console/Commands` directory in your Laravel application.

The command is already included in Laravel's default `artisan` commands, so no further configuration is required.

## Command Usage

The `job:run` command executes a specified method from a job class with optional parameters.

### Syntax:

```bash
php artisan job:run {class} {method} {parameters?*}
```

-   **`class`**: The fully-qualified class name of the job you want to run (e.g., `App\Jobs\SampleJob`).
-   **`method`**: The name of the method you want to call on the job (e.g., `execute`).
-   **`parameters` (optional)**: Any parameters to pass to the method. Parameters should be passed as a space-separated list and will be encoded as JSON.

### Example Command:

```bash
php artisan job:run "App\Jobs\SampleJob" "execute" '{"message": "This is a test message"}'
```

This will execute the `execute` method of the `SampleJob` class, passing the `{"message": "This is a test message"}` parameter.

### Example Output:

-   **Success:**

```bash
Job App\Jobs\SampleJob::execute executed successfully.
```

-   **Error (Class or Method not found):**

```bash
Class App\Jobs\SampleJob not found.
```

```bash
Method execute not found in class App\Jobs\SampleJob.
```

## Parameters:

-   **`parameters`**: This argument is optional. If no parameters are provided, an empty array will be passed to the method. If parameters are provided, they must be passed as a JSON-encoded string, and the command will decode them into an array for use in the method.

Example with multiple parameters:

```bash
php artisan job:run "App\Jobs\SampleJob" "execute" '{"message": "Hello", "id": 123}'
```

In this case, the `execute` method will receive an array with keys `message` and `id`.

## Error Handling:

-   If the specified job class does not exist, the command will log an error and display a message: `Class {class} not found.`
-   If the specified method does not exist in the class, the command will log an error and display a message: `Method {method} not found in class {class}.`
-   If there is any issue during the execution of the method (e.g., exception thrown), the command will log the error and display it.

## Code Overview:

The `JobRunCommand` class has the following behavior:

1. **Class Validation**: It checks if the specified class exists using `class_exists()`. If not, it logs an error and exits.
2. **Method Validation**: It checks if the specified method exists in the class using `method_exists()`. If not, it logs an error and exits.
3. **Execution**: The class is instantiated, and the method is called using `call_user_func_array()`, passing the parameters.
4. **Logging**: Both success and error messages are logged for monitoring purposes.

---

## Troubleshooting:

-   **Class Not Found**: Ensure that the class you are passing to the command is fully qualified and matches the namespace. For example, `App\Jobs\SampleJob` should be the exact path of your job class.
-   **Method Not Found**: Ensure that the method you're trying to call exists in the job class and is publicly accessible.

If you encounter any issues, check your Laravel logs for detailed error messages, which may provide further insight into the problem.
