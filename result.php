<?php include 'conn.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Result Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="stylev4.css">
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
                    <a class="nav-link" href="about.php">About me</a>
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
            $hobby = array("ไม่มี");
        }
        if (isset($_POST['aptitude'])) {
            $selectedAptitude = $_POST['aptitude'];
            #$selectedAptitudeString = implode(', ', $selectedAptitude);
            $aptitude = $selectedAptitude;
        } else {
            $aptitude = array("ไม่มี");
        }
        if (isset($_POST['commute'])) {
            $selectedCommute = $_POST['commute'];
            #$selectedCommuteString = implode(', ', $selectedCommute);
            $commute = $selectedCommute;
        } else {
            $commute = "ทำงานที่บ้าน (WFH)";
        }

        if ($_POST['tool'] === "ไม่มี") {
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
            $tool = "3.5";
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
            'gender' => 2.8,
            'education' => 5,
            'status_' => 2.8,
            'dis_type' => 4.1,
            'tool' => 4.7,
            'keeper' => 4.6,
            'invest' => 4.1,
            'loan' => 2.4,
            'hobby' => 10,
            'aptitude' => 9.5,
            'commute' => 6.3
        );

        $sumOfWeights = 0;
        foreach ($attributeWeights as $weight) {
            $sumOfWeights += $weight;
        }
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
        $elementsToRemove = array(
            'ขับรถรับจ้าง',
            'ช่างซ่อมรถ, ช่างตัดผม',
            'ช่างไฟฟ้าและเขียนแบบAutocad',
            'ทำงานตรวจสอบและวิเคราะห์',
            'ทำเอกสาร',
            'นักลงทุน',
            'นักวาดภาพ',
            'พนักงานส่งของเคอรี่',
            'พนักงานเสิร์ฟอาหาร',
            'รับจ้างขายของ หรือทำความสะอาด',
            'รับจ้างซ่อมเครื่องยนต์',
            'รับจ้างทำการเกษตร',
            'รับจ้างส่งของ',
            'แม่บ้าน',
            'เกษตรกร',
            'เย็บผ้า ปักผ้า',
            'แม่ค้าเบเกอรี่ออนไลน์',
            'โปรแกรมเมอร์',
            'ไรเดอร์ส่งอาหาร',
            'ขับแท็กซี่',
            'พนักงานโรงงาน'
        );
        
        foreach ($topSimilarCases as $case) {
            if ($_POST['dis_type'] == 9 && in_array($case['caseDetails']['occupation'], $elementsToRemove)) {
                continue;
            }
            if ($_POST['dis_type'] == 4 && $case['caseDetails']['occupation'] == 'นักดนตรี') {
                continue;
            }
            $uniqueCases[] = $case['caseDetails']['occupation'];
        }

        $nextSimilarCases = array_slice($similarCases, 5);

        ?>

        <h2 class="center-text">อันดับอาชีพที่แนะนำ</h2>

        <?php if (empty($uniqueCases)): ?>
            <p>ไม่พบกรณีที่ใกล้เคียง</p>
        <?php else: ?>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>อันดับ</th>
                            <th>อาชีพที่แนะนำ</th>
                            <th>ค่าคล้ายคลึง</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        foreach ($uniqueCases as $case):
                            ?>
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
                                            echo number_format((($topCase['similarity'] / $sumOfWeights) * 100), 2) . '%';
                                            break;
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $counter++;
                        endforeach;
                        ?>

                        <?php
                        foreach ($nextSimilarCases as $nextCase) {
                            if ($counter > 5) {
                                break;
                            }
                            if (!in_array($nextCase['caseDetails']['occupation'], $uniqueCases) && !in_array($nextCase['caseDetails']['occupation'], $elementsToRemove)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $counter; ?>
                                    </td>
                                    <td>
                                        <?php echo $nextCase['caseDetails']['occupation']; ?>
                                    </td>
                                    <td>
                                        <?php echo number_format((($nextCase['similarity'] / $sumOfWeights) * 100), 2) . '%'; ?>
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
            </div>
        <?php endif; ?>
        <br>
        <div class="btn-container">
            <a href="index.php" class="btn btn-primary">กลับสู่หน้าหลัก</a>
        </div>

    </div>
</body>

</html>