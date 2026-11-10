<?php

declare(strict_types=1);

require_once "db.php";

require_admin();


if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    verify_csrf(
        $_POST['csrf_token'] ?? null
    )
) {

    $id =
        (int)($_POST['id'] ?? 0);

    $status =
        $_POST['status'] ?? 'new';


    if (
        $id > 0 &&
        in_array(
            $status,
            ['new', 'read', 'resolved'],
            true
        )
    ) {

        $stmt =
            $conn->prepare(
                "UPDATE customer_queries
                 SET status = ?
                 WHERE id = ?"
            );

        $stmt->bind_param(
            "si",
            $status,
            $id
        );

        $stmt->execute();
        $stmt->close();

    }

}


$result = $conn->query(
    "SELECT
        id,
        name,
        email,
        phone,
        message,
        status,
        created_at
     FROM customer_queries
     ORDER BY id DESC"
);

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>

<title>Customer Messages</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

</head>

<body class="bg-light">

<?php require "sidebar.php"; ?>


<main class="container-fluid p-4">

    <h1 class="mb-1">
        Customer Messages
    </h1>

    <p class="text-muted mb-4">
        Manage enquiries received from the hotel website.
    </p>


    <div class="table-responsive bg-white rounded-4 shadow-sm">

        <table class="table align-middle mb-0">

            <thead>

                <tr>

                    <th>Name</th>
                    <th>Contact</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

            <?php if (
                $result &&
                $result->num_rows > 0
            ): ?>

                <?php while (
                    $row = $result->fetch_assoc()
                ): ?>

                    <tr>

                        <td>
                            <strong>
                                <?= htmlspecialchars(
                                    $row['name']
                                ) ?>
                            </strong>
                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $row['email']
                            ) ?>

                            <br>

                            <small>
                                <?= htmlspecialchars(
                                    $row['phone']
                                ) ?>
                            </small>

                        </td>


                        <td style="max-width:350px">

                            <?= nl2br(
                                htmlspecialchars(
                                    $row['message']
                                )
                            ) ?>

                        </td>


                        <td>

                            <span class="badge
                                <?=
                                $row['status'] === 'new'
                                    ? 'bg-danger'
                                    : (
                                        $row['status'] === 'read'
                                            ? 'bg-warning text-dark'
                                            : 'bg-success'
                                    )
                                ?>
                            ">

                                <?= ucfirst(
                                    $row['status']
                                ) ?>

                            </span>

                        </td>


                        <td>

                            <form
                                method="POST"
                                class="d-flex gap-2"
                            >

                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= htmlspecialchars(
                                        csrf_token()
                                    ) ?>"
                                >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int)$row['id'] ?>"
                                >


                                <select
                                    name="status"
                                    class="form-select form-select-sm"
                                >

                                    <option
                                        value="new"
                                        <?= $row['status'] === 'new'
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        New
                                    </option>

                                    <option
                                        value="read"
                                        <?= $row['status'] === 'read'
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        Read
                                    </option>

                                    <option
                                        value="resolved"
                                        <?= $row['status'] === 'resolved'
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        Resolved
                                    </option>

                                </select>


                                <button
                                    class="btn btn-sm btn-success"
                                >
                                    Save
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td
                        colspan="5"
                        class="text-center py-5 text-muted"
                    >
                        No customer messages yet.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</main>

</body>
</html>