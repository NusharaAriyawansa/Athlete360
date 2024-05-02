<form action="<?php echo URLROOT; ?>/C_Performance/processEditMatchStat" method="post">
    <input type="hidden" name="id" value="<?php echo $data['statDetails']->id; ?>">
    <!-- Include fields for match name, date, runs, wickets, catches, and run outs -->
    <button type="submit">Update Statistic</button>
</form>