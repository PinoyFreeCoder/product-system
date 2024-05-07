# Product Listing | PHP and MySQL

## Getting Started

Download this repository or clone it using Git Clone

```
$ git https://github.com/PinoyFreeCoder/product-system.git

```

## Setup Connection

Under function.php provide your mysql host, database and crendentials

```
function connect()
{

    $host = 'localhost';
    $dbname = 'productsystem';
    $username = 'root';
    $password = '123456';

    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

```

## Contributing to the Repository

To contribute to the repository, follow these steps:

1. **Create a Branch:**
   - Before making any changes, create a new branch to work in. This helps isolate your changes from the main codebase.
   - Use the `git checkout -b` command followed by a descriptive branch name:
     ```
     git checkout -b feature/new-feature
     ```

2. **Make Changes:**
   - Make your desired changes to the codebase using your preferred text editor or IDE.

3. **Commit Changes:**
   - Once you've made your changes, stage them for commit using the `git add` command:
     ```
     git add .
     ```
   - Commit the staged changes with a descriptive commit message:
     ```
     git commit -m "Add new feature"
     ```

4. **Push Changes:**
   - Push your changes to your fork of the repository on GitHub:
     ```
     git push origin feature/new-feature
     ```

5. **Create a Pull Request:**
   - Go to the GitHub repository in your web browser.
   - Click on the "Pull Requests" tab.
   - Click on the "New Pull Request" button.
   - Select the branch you made your changes in from the "Compare" dropdown menu.
   - Review your changes and provide a descriptive title and comment.
   - Click on the "Create Pull Request" button to submit your changes for review.

6. **Review and Merge:**
   - Wait for feedback from project maintainers. They may ask for further changes or approve your pull request.
   - Once approved, your changes will be merged into the main codebase.
