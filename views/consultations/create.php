<h2>Course Consultation Form</h2>

<form method="POST"
      action="/consultations">

    <input type="text"
           name="website"
           class="honeypot">

    <div class="form-group">

        <label>Full Name</label>

        <input type="text"
               name="full_name"
               value="<?= h(old('full_name')) ?>">

        <?php if(errors('full_name')): ?>
            <small class="error-text">
                <?= h(errors('full_name')) ?>
            </small>
        <?php endif; ?>

    </div>

    <div class="form-group">

        <label>Email</label>

        <input type="email"
               name="email"
               value="<?= h(old('email')) ?>">

        <?php if(errors('email')): ?>
            <small class="error-text">
                <?= h(errors('email')) ?>
            </small>
        <?php endif; ?>

    </div>

    <div class="form-group">

        <label>Phone</label>

        <input type="text"
               name="phone"
               value="<?= h(old('phone')) ?>">

        <?php if(errors('phone')): ?>
            <small class="error-text">
                <?= h(errors('phone')) ?>
            </small>
        <?php endif; ?>

    </div>

    <div class="form-group">

        <label>Course</label>

        <select name="course">

            <option value="">
                Select Course
            </option>

            <?php
            $courses = [
                'Web Development',
                'Data Analysis',
                'Digital Marketing',
                'UI/UX Design',
                'English Communication'
            ];
            ?>

            <?php foreach($courses as $course): ?>

                <option
                    value="<?= $course ?>"
                    <?= old('course') === $course ? 'selected' : '' ?>>

                    <?= h($course) ?>

                </option>

            <?php endforeach; ?>

        </select>

        <?php if(errors('course')): ?>
            <small class="error-text">
                <?= h(errors('course')) ?>
            </small>
        <?php endif; ?>

    </div>

    <div class="form-group">

        <label>Study Mode</label>

        <select name="study_mode">

            <option value="">
                Select Mode
            </option>

            <?php
            $modes = [
                'Online',
                'Offline',
                'Hybrid'
            ];
            ?>

            <?php foreach($modes as $mode): ?>

                <option
                    value="<?= $mode ?>"
                    <?= old('study_mode') === $mode ? 'selected' : '' ?>>

                    <?= h($mode) ?>

                </option>

            <?php endforeach; ?>

        </select>

        <?php if(errors('study_mode')): ?>
            <small class="error-text">
                <?= h(errors('study_mode')) ?>
            </small>
        <?php endif; ?>

    </div>

    <div class="form-group">

        <label>Learning Goal</label>

        <textarea
            name="goal"
            rows="5"><?= h(old('goal')) ?></textarea>

        <?php if(errors('goal')): ?>
            <small class="error-text">
                <?= h(errors('goal')) ?>
            </small>
        <?php endif; ?>

    </div>

    <button type="submit">
        Submit Consultation
    </button>

</form>

<?php
unset($_SESSION['_old']);
unset($_SESSION['_errors']);
?>