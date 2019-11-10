<h1>Bulk User Importer</h1>
<div class="content">
    <?= $this->Flash->render() ?>
    <div class="upload-frm">
        <?php /** @var file $uploadData */
        echo $this->Form->create($uploadData, ['type' => 'file']); ?>
            <?php echo $this->Form->control('file', ['type' => 'file', 'class' => 'form-control']); ?>
            <?php echo $this->Form->button(__('Upload CSV'), ['type'=>'submit', 'class' => 'form-controlbtn btn-default']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
if (isset($successfulRecordCount)) {
    echo 'Successful Record Count: ' . $successfulRecordCount;
}

echo '</br>';
echo '</br>';

if (isset($invalidRows)) {
    echo 'Invalid Rows: </br>';
    echo $invalidRows;
}

echo '</br>';
echo '</br>';

if (isset($validRows)) {
    echo 'Valid Rows: </br>';
    echo $validRows;
}
