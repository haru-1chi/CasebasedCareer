<?php include 'conn.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <title>Result Page</title>
  <link rel="stylesheet" href="stylev3.css">
</head>

<body>
  <nav class="navbar">
    <div class="container-nav">
      <a class="navbar-brand" href="index.php">CasebasedOccupation</a>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About me</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <h1 class="center-text">ผลการวิเคราะห์</h1>

    <?php
    if (isset($_POST['hobby'])) {
      $selectedHobbies = $_POST['hobby'];
      #$selectedHobbiesString = implode(', ', $selectedHobbies);
      $hobby = $selectedHobbies;
    } else {
      $hobby = "ไม่มี";
    }
    if (isset($_POST['aptitude'])) {
      $selectedAptitude = $_POST['aptitude'];
      #$selectedAptitudeString = implode(', ', $selectedAptitude);
      $aptitude = $selectedAptitude;
    } else {
      $aptitude = "ไม่มี";
    }
    if (isset($_POST['commute'])) {
      $selectedCommute = $_POST['commute'];
      #$selectedCommuteString = implode(', ', $selectedCommute);
      $commute = $selectedCommute;
    } else {
      $commute = "ทำงานที่บ้าน (WFH)";
    }

    if ($_POST['tool'] === "") {
      $tool = "1";
    } else if ($_POST['tool'] === "เครื่องช่วยฟัง") {
      $tool = "2";
    } else if ($_POST['tool'] === "เขียนพิมพ์สื่อสาร") {
      $tool = "3";
    } else if ($_POST['tool'] === "ไม้เท้า") {
      $tool = "4";
    } else if ($_POST['tool'] === "ไม้ค้ำยัน") {
      $tool = "5";
    } else if ($_POST['tool'] === "ขาเทียม") {
      $tool = "6";
    } else if ($_POST['tool'] === "วิลแชร์") {
      $tool = "7";
    } else {
      $tool = "0";
    }

    $currentProblem = array(
      'gender' => $_POST['gender'],
      'education' => $_POST['education'],
      'status_' => $_POST['status_'],
      'dis_type' => $_POST['dis_type'],
      'tool' => $tool ?? "1",
      'keeper' => $_POST['keeper'] ?? "ไม่มี",
      'invest' => $_POST['invest'] ?? "0",
      'loan' => $_POST['loan'] ?? "0",
      'hobby' => $hobby,
      'aptitude' => $aptitude,
      'commute' => $commute
    );

    $attributeWeights = array(
      'gender' => 1,
      'education' => 4.6,
      'status_' => 2.5,
      'dis_type' => 3.8,
      'tool' => 4.3,
      'keeper' => 4.2,
      'invest' => 3.8,
      'loan' => 2.2,
      'hobby' => 9.1,
      'aptitude' => 8.7,
      'commute' => 5.8
    );

    function calculateSimilarity($currentProblem, $retrievedCase, $attributeWeights)
    {
      $similarity = 0;
      foreach ($attributeWeights as $attribute => $weight) {

        if ($attribute === 'hobby' || $attribute === 'aptitude' || $attribute === 'commute') {
          if (isset($retrievedCase[$attribute])) {
            $retrievedCase[$attribute] = explode(", ", $retrievedCase[$attribute]);
          }
        }
        if (is_array($currentProblem[$attribute])) {
          $currentValues = $currentProblem[$attribute];
          $retrievedValues = $retrievedCase[$attribute];
          $matchingValues = array_intersect($currentValues, $retrievedValues);
          $attributeSimilarity = (2 * count($matchingValues)) / (count($currentValues) + count($retrievedValues));
        } else if ($attribute === 'education') {
          $currentValues = $currentProblem[$attribute];
          $retrievedValues = $retrievedCase[$attribute];
          $attributeSimilarity = 1 - (abs($currentValues - $retrievedValues) / 7);
        } else if ($attribute === 'dis_type') {
          $currentValues = $currentProblem[$attribute];
          $retrievedValues = $retrievedCase[$attribute];
          $attributeSimilarity = 1 - (abs($currentValues - $retrievedValues) / 9);

        } else if ($attribute === 'tool') {
          $currentValues = $currentProblem[$attribute];
          $retrievedValues = $retrievedCase[$attribute];
          $attributeSimilarity = 1 - (abs($currentValues - $retrievedValues) / 7);

        } else if ($attribute === 'invest') {
          $currentValues = $currentProblem[$attribute];
          $retrievedValues = $retrievedCase[$attribute];
          $attributeSimilarity = 1 / (1 + abs($currentValues - $retrievedValues));

        } else if ($attribute === 'loan') {
          $currentValues = $currentProblem[$attribute];
          $retrievedValues = $retrievedCase[$attribute];
          $attributeSimilarity = 1 / (1 + abs($currentValues - $retrievedValues));

        } else {
          $attributeSimilarity = ($currentProblem[$attribute] == $retrievedCase[$attribute]) ? 1 : 0;

        }

        $similarity += $weight * $attributeSimilarity;
      }

      return $similarity;
    }

    $sql = "SELECT * FROM `data_newer1`";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
      $similarity = calculateSimilarity($currentProblem, $row, $attributeWeights);

      $similarCases[] = array(
        'similarity' => $similarity,
        'caseDetails' => $row
      );
    }

    usort($similarCases, function ($a, $b) {
      return $b['similarity'] <=> $a['similarity'];
    });

    $topSimilarCases = array_slice($similarCases, 0, 5);
    $uniqueCases = [];

    foreach ($topSimilarCases as $case) {
      if (!in_array($case['caseDetails']['occupation'], $uniqueCases)) {
        $uniqueCases[] = $case['caseDetails']['occupation'];
      }
    }

    $nextSimilarCases = array_slice($similarCases, 5);

    ?>

    <h2 class="center-text">อันดับอาชีพที่แนะนำ</h2>

    <?php if (empty($uniqueCases)): ?>
      <p>ไม่พบกรณีที่ใกล้เคียง</p>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>อันดับ</th>
            <th>อาชีพที่แนะนำ</th>
            <th>ค่าความคล้ายคลึง</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $counter = 1;
          foreach ($uniqueCases as $case): ?>
            <tr>
              <td>
                <?php echo $counter; ?>
              </td>
              <td>
                <?php echo $case; ?>
              </td>
              <td>
                <?php
                foreach ($topSimilarCases as $topCase) {
                  if ($topCase['caseDetails']['occupation'] === $case) {
                    echo number_format((($topCase['similarity'] / 50) * 100), 2) . '%';
                    break;
                  }
                }
                ?>
              </td>
            </tr>
            <?php
            $counter++;
          endforeach; ?>

          <?php
          foreach ($nextSimilarCases as $nextCase) {
            if ($counter > 5) {
              break;
            }
            if (!in_array($nextCase['caseDetails']['occupation'], $uniqueCases)) {
              ?>
              <tr>
                <td>
                  <?php echo $counter; ?>
                </td>
                <td>
                  <?php echo $nextCase['caseDetails']['occupation']; ?>
                </td>
                <td>
                  <?php echo number_format((($nextCase['similarity'] / 50) * 100), 2) . '%'; ?>
                </td>
              </tr>
              <?php
              $counter++;
              $uniqueCases[] = $nextCase['caseDetails']['occupation'];
            }
          }
          ?>
        </tbody>
      </table>
    <?php endif; ?>
    <br>
    <div class="btn-container">
      <a href="index.php" class="btn btn-primary">กลับสู่หน้าหลัก</a>
    </div>

    <script>
    </script>

  </div>
</body>

</html>