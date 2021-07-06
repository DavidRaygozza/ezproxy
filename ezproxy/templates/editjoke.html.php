<?php if (!empty($joke['id']) || $userId == $joke['authorId']):


?>

 <!-- 5/27/20 DavidR MOD 5L: Updated to return workout description  -->
<form action="" method="post">
	<input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? ''?>">
    <label for="workoutdescription">Type your workout here:</label>
    <textarea id="workoutdescription" name="joke[workoutdescription]" rows="3" cols="40"><?=$joke['workoutdescription'] ?? ''?></textarea>

 <!-- 5/27/20 DavidR NEW 25L: Created new data entries for suer to enter sets, reps, wrokout difficulty, and target area when editing or adding a new joke. This will be passed to the database -->
<label for="workoutdifficulty">Dicciculty Rank (1 is easiest): </label>
<select name = "joke[workoutdifficulty]" id = "workoutdifficulty">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
<?=$joke['workoutdifficulty'] ?? ''?>
</select>

<label for="sets">Sets: </label>
        <input type="text" name="joke[sets]" value="<?=$joke['sets'] ?? ''?>">

<label for="reps">Reps: </label>
      <input type="text" name="joke[reps]" value="<?=$joke['reps'] ?? ''?>">


<label for="targetarea">Target Area: </label>
<select name = "joke[targetarea]" id = "targetarea">
  <option value="Upper">Upper</option>
  <option value="Lower">Lower</option>
  <option value="Abs">Abs</option>
  <option value="Cardio">Cardio</option>
<?=$joke['targetarea'] ?? ''?>
</select>

    <input type="submit" name="submit" value="Save">
</form>
<?php else: ?>

<p>You may only edit jokes that you posted.</p>

<?php endif; ?>
