﻿<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()>
Partial Class Personal
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()>
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()>
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Me.TabControl1 = New System.Windows.Forms.TabControl()
        Me.TabPage1 = New System.Windows.Forms.TabPage()
        Me.lblAccount = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.DataGridView1 = New System.Windows.Forms.DataGridView()
        Me.TabPage2 = New System.Windows.Forms.TabPage()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.Button2 = New System.Windows.Forms.Button()
        Me.DataGridView2 = New System.Windows.Forms.DataGridView()
        Me.NameDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.RankDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.RaceDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.GenderDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.ProfessionDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.LevelDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.AgeDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.DeathsDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.CharacterBindingSource = New System.Windows.Forms.BindingSource(Me.components)
        Me.PvprankDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.AggregateDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.ProfessionsDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.LaddersDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.PVPBindingSource = New System.Windows.Forms.BindingSource(Me.components)
        Me.TabControl1.SuspendLayout()
        Me.TabPage1.SuspendLayout()
        CType(Me.DataGridView1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.TabPage2.SuspendLayout()
        CType(Me.DataGridView2, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.CharacterBindingSource, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PVPBindingSource, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'TabControl1
        '
        Me.TabControl1.Anchor = CType((((System.Windows.Forms.AnchorStyles.Top Or System.Windows.Forms.AnchorStyles.Bottom) _
            Or System.Windows.Forms.AnchorStyles.Left) _
            Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.TabControl1.Controls.Add(Me.TabPage1)
        Me.TabControl1.Controls.Add(Me.TabPage2)
        Me.TabControl1.Location = New System.Drawing.Point(12, 12)
        Me.TabControl1.Name = "TabControl1"
        Me.TabControl1.SelectedIndex = 0
        Me.TabControl1.Size = New System.Drawing.Size(858, 539)
        Me.TabControl1.TabIndex = 0
        '
        'TabPage1
        '
        Me.TabPage1.Controls.Add(Me.lblAccount)
        Me.TabPage1.Controls.Add(Me.Label2)
        Me.TabPage1.Controls.Add(Me.DataGridView1)
        Me.TabPage1.Location = New System.Drawing.Point(4, 22)
        Me.TabPage1.Name = "TabPage1"
        Me.TabPage1.Padding = New System.Windows.Forms.Padding(3)
        Me.TabPage1.Size = New System.Drawing.Size(850, 513)
        Me.TabPage1.TabIndex = 0
        Me.TabPage1.Text = "     My Character List     "
        Me.TabPage1.UseVisualStyleBackColor = True
        '
        'lblAccount
        '
        Me.lblAccount.AutoSize = True
        Me.lblAccount.Font = New System.Drawing.Font("Microsoft Sans Serif", 13.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblAccount.Location = New System.Drawing.Point(6, 29)
        Me.lblAccount.Name = "lblAccount"
        Me.lblAccount.Size = New System.Drawing.Size(72, 22)
        Me.lblAccount.TabIndex = 2
        Me.lblAccount.Text = "{name}"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Location = New System.Drawing.Point(7, 7)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(78, 13)
        Me.Label2.TabIndex = 1
        Me.Label2.Text = "Account Name"
        '
        'DataGridView1
        '
        Me.DataGridView1.AllowUserToAddRows = False
        Me.DataGridView1.AllowUserToDeleteRows = False
        Me.DataGridView1.AllowUserToOrderColumns = True
        Me.DataGridView1.AutoGenerateColumns = False
        Me.DataGridView1.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.DataGridView1.Columns.AddRange(New System.Windows.Forms.DataGridViewColumn() {Me.NameDataGridViewTextBoxColumn, Me.RankDataGridViewTextBoxColumn, Me.RaceDataGridViewTextBoxColumn, Me.GenderDataGridViewTextBoxColumn, Me.ProfessionDataGridViewTextBoxColumn, Me.LevelDataGridViewTextBoxColumn, Me.AgeDataGridViewTextBoxColumn, Me.DeathsDataGridViewTextBoxColumn})
        Me.DataGridView1.DataSource = Me.CharacterBindingSource
        Me.DataGridView1.Location = New System.Drawing.Point(3, 64)
        Me.DataGridView1.Name = "DataGridView1"
        Me.DataGridView1.ReadOnly = True
        Me.DataGridView1.Size = New System.Drawing.Size(845, 378)
        Me.DataGridView1.TabIndex = 0
        '
        'TabPage2
        '
        Me.TabPage2.Controls.Add(Me.DataGridView2)
        Me.TabPage2.Location = New System.Drawing.Point(4, 22)
        Me.TabPage2.Name = "TabPage2"
        Me.TabPage2.Padding = New System.Windows.Forms.Padding(3)
        Me.TabPage2.Size = New System.Drawing.Size(850, 513)
        Me.TabPage2.TabIndex = 1
        Me.TabPage2.Text = "Pvp Info"
        Me.TabPage2.UseVisualStyleBackColor = True
        '
        'Button1
        '
        Me.Button1.Anchor = CType((System.Windows.Forms.AnchorStyles.Bottom Or System.Windows.Forms.AnchorStyles.Right), System.Windows.Forms.AnchorStyles)
        Me.Button1.Location = New System.Drawing.Point(791, 557)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(75, 23)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Close"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'Button2
        '
        Me.Button2.Location = New System.Drawing.Point(698, 557)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(75, 23)
        Me.Button2.TabIndex = 1
        Me.Button2.Text = "Refresh"
        Me.Button2.UseVisualStyleBackColor = True
        '
        'DataGridView2
        '
        Me.DataGridView2.AllowUserToAddRows = False
        Me.DataGridView2.AllowUserToDeleteRows = False
        Me.DataGridView2.AutoGenerateColumns = False
        Me.DataGridView2.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.DataGridView2.Columns.AddRange(New System.Windows.Forms.DataGridViewColumn() {Me.PvprankDataGridViewTextBoxColumn, Me.AggregateDataGridViewTextBoxColumn, Me.ProfessionsDataGridViewTextBoxColumn, Me.LaddersDataGridViewTextBoxColumn})
        Me.DataGridView2.DataBindings.Add(New System.Windows.Forms.Binding("Tag", Me.PVPBindingSource, "aggregate", True))
        Me.DataGridView2.DataSource = Me.PVPBindingSource
        Me.DataGridView2.Location = New System.Drawing.Point(6, 40)
        Me.DataGridView2.Name = "DataGridView2"
        Me.DataGridView2.ReadOnly = True
        Me.DataGridView2.Size = New System.Drawing.Size(838, 150)
        Me.DataGridView2.TabIndex = 0
        '
        'NameDataGridViewTextBoxColumn
        '
        Me.NameDataGridViewTextBoxColumn.DataPropertyName = "Name"
        Me.NameDataGridViewTextBoxColumn.HeaderText = "Name"
        Me.NameDataGridViewTextBoxColumn.Name = "NameDataGridViewTextBoxColumn"
        Me.NameDataGridViewTextBoxColumn.ReadOnly = True
        '
        'RankDataGridViewTextBoxColumn
        '
        Me.RankDataGridViewTextBoxColumn.DataPropertyName = "Rank"
        Me.RankDataGridViewTextBoxColumn.HeaderText = "Rank"
        Me.RankDataGridViewTextBoxColumn.Name = "RankDataGridViewTextBoxColumn"
        Me.RankDataGridViewTextBoxColumn.ReadOnly = True
        '
        'RaceDataGridViewTextBoxColumn
        '
        Me.RaceDataGridViewTextBoxColumn.DataPropertyName = "Race"
        Me.RaceDataGridViewTextBoxColumn.HeaderText = "Race"
        Me.RaceDataGridViewTextBoxColumn.Name = "RaceDataGridViewTextBoxColumn"
        Me.RaceDataGridViewTextBoxColumn.ReadOnly = True
        '
        'GenderDataGridViewTextBoxColumn
        '
        Me.GenderDataGridViewTextBoxColumn.DataPropertyName = "Gender"
        Me.GenderDataGridViewTextBoxColumn.HeaderText = "Gender"
        Me.GenderDataGridViewTextBoxColumn.Name = "GenderDataGridViewTextBoxColumn"
        Me.GenderDataGridViewTextBoxColumn.ReadOnly = True
        '
        'ProfessionDataGridViewTextBoxColumn
        '
        Me.ProfessionDataGridViewTextBoxColumn.DataPropertyName = "Profession"
        Me.ProfessionDataGridViewTextBoxColumn.HeaderText = "Profession"
        Me.ProfessionDataGridViewTextBoxColumn.Name = "ProfessionDataGridViewTextBoxColumn"
        Me.ProfessionDataGridViewTextBoxColumn.ReadOnly = True
        '
        'LevelDataGridViewTextBoxColumn
        '
        Me.LevelDataGridViewTextBoxColumn.DataPropertyName = "Level"
        Me.LevelDataGridViewTextBoxColumn.HeaderText = "Level"
        Me.LevelDataGridViewTextBoxColumn.Name = "LevelDataGridViewTextBoxColumn"
        Me.LevelDataGridViewTextBoxColumn.ReadOnly = True
        '
        'AgeDataGridViewTextBoxColumn
        '
        Me.AgeDataGridViewTextBoxColumn.DataPropertyName = "Age"
        Me.AgeDataGridViewTextBoxColumn.HeaderText = "Age"
        Me.AgeDataGridViewTextBoxColumn.Name = "AgeDataGridViewTextBoxColumn"
        Me.AgeDataGridViewTextBoxColumn.ReadOnly = True
        '
        'DeathsDataGridViewTextBoxColumn
        '
        Me.DeathsDataGridViewTextBoxColumn.DataPropertyName = "Deaths"
        Me.DeathsDataGridViewTextBoxColumn.HeaderText = "Deaths"
        Me.DeathsDataGridViewTextBoxColumn.Name = "DeathsDataGridViewTextBoxColumn"
        Me.DeathsDataGridViewTextBoxColumn.ReadOnly = True
        '
        'CharacterBindingSource
        '
        Me.CharacterBindingSource.DataSource = GetType(Models.Character)
        '
        'PvprankDataGridViewTextBoxColumn
        '
        Me.PvprankDataGridViewTextBoxColumn.AutoSizeMode = System.Windows.Forms.DataGridViewAutoSizeColumnMode.Fill
        Me.PvprankDataGridViewTextBoxColumn.DataPropertyName = "pvp_rank"
        Me.PvprankDataGridViewTextBoxColumn.HeaderText = "PVP Rank"
        Me.PvprankDataGridViewTextBoxColumn.Name = "PvprankDataGridViewTextBoxColumn"
        Me.PvprankDataGridViewTextBoxColumn.ReadOnly = True
        Me.PvprankDataGridViewTextBoxColumn.ToolTipText = "The player's PvP rank"
        '
        'AggregateDataGridViewTextBoxColumn
        '
        Me.AggregateDataGridViewTextBoxColumn.AutoSizeMode = System.Windows.Forms.DataGridViewAutoSizeColumnMode.Fill
        Me.AggregateDataGridViewTextBoxColumn.DataPropertyName = "aggregate"
        Me.AggregateDataGridViewTextBoxColumn.HeaderText = "Win/Loss"
        Me.AggregateDataGridViewTextBoxColumn.Name = "AggregateDataGridViewTextBoxColumn"
        Me.AggregateDataGridViewTextBoxColumn.ReadOnly = True
        Me.AggregateDataGridViewTextBoxColumn.ToolTipText = "A win/loss object (see below) containing stats from all matches ever played"
        '
        'ProfessionsDataGridViewTextBoxColumn
        '
        Me.ProfessionsDataGridViewTextBoxColumn.AutoSizeMode = System.Windows.Forms.DataGridViewAutoSizeColumnMode.Fill
        Me.ProfessionsDataGridViewTextBoxColumn.DataPropertyName = "professions"
        Me.ProfessionsDataGridViewTextBoxColumn.HeaderText = "Main Profession"
        Me.ProfessionsDataGridViewTextBoxColumn.Name = "ProfessionsDataGridViewTextBoxColumn"
        Me.ProfessionsDataGridViewTextBoxColumn.ReadOnly = True
        Me.ProfessionsDataGridViewTextBoxColumn.ToolTipText = "Your profession played in PvP"
        '
        'LaddersDataGridViewTextBoxColumn
        '
        Me.LaddersDataGridViewTextBoxColumn.AutoSizeMode = System.Windows.Forms.DataGridViewAutoSizeColumnMode.Fill
        Me.LaddersDataGridViewTextBoxColumn.DataPropertyName = "ladders"
        Me.LaddersDataGridViewTextBoxColumn.HeaderText = "Ladders"
        Me.LaddersDataGridViewTextBoxColumn.Name = "LaddersDataGridViewTextBoxColumn"
        Me.LaddersDataGridViewTextBoxColumn.ReadOnly = True
        Me.LaddersDataGridViewTextBoxColumn.ToolTipText = "The type of ladder (i.e. ranked, unranked)"
        '
        'PVPBindingSource
        '
        Me.PVPBindingSource.DataSource = GetType(Models.PVP)
        '
        'Personal
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(882, 586)
        Me.ControlBox = False
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.TabControl1)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.SizableToolWindow
        Me.MaximizeBox = False
        Me.Name = "Personal"
        Me.ShowIcon = False
        Me.ShowInTaskbar = False
        Me.Text = "Personal"
        Me.TabControl1.ResumeLayout(False)
        Me.TabPage1.ResumeLayout(False)
        Me.TabPage1.PerformLayout()
        CType(Me.DataGridView1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.TabPage2.ResumeLayout(False)
        CType(Me.DataGridView2, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.CharacterBindingSource, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PVPBindingSource, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub

    Friend WithEvents TabControl1 As TabControl
    Friend WithEvents TabPage1 As TabPage
    Friend WithEvents TabPage2 As TabPage
    Friend WithEvents Button1 As Button
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents DataGridView1 As System.Windows.Forms.DataGridView
    Friend WithEvents CharacterBindingSource As System.Windows.Forms.BindingSource
    Friend WithEvents NameDataGridViewTextBoxColumn As System.Windows.Forms.DataGridViewTextBoxColumn
    Friend WithEvents RankDataGridViewTextBoxColumn As System.Windows.Forms.DataGridViewTextBoxColumn
    Friend WithEvents RaceDataGridViewTextBoxColumn As System.Windows.Forms.DataGridViewTextBoxColumn
    Friend WithEvents GenderDataGridViewTextBoxColumn As System.Windows.Forms.DataGridViewTextBoxColumn
    Friend WithEvents ProfessionDataGridViewTextBoxColumn As System.Windows.Forms.DataGridViewTextBoxColumn
    Friend WithEvents LevelDataGridViewTextBoxColumn As System.Windows.Forms.DataGridViewTextBoxColumn
    Friend WithEvents AgeDataGridViewTextBoxColumn As System.Windows.Forms.DataGridViewTextBoxColumn
    Friend WithEvents DeathsDataGridViewTextBoxColumn As System.Windows.Forms.DataGridViewTextBoxColumn
    Friend WithEvents lblAccount As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents DataGridView2 As DataGridView
    Friend WithEvents PvprankDataGridViewTextBoxColumn As DataGridViewTextBoxColumn
    Friend WithEvents AggregateDataGridViewTextBoxColumn As DataGridViewTextBoxColumn
    Friend WithEvents ProfessionsDataGridViewTextBoxColumn As DataGridViewTextBoxColumn
    Friend WithEvents LaddersDataGridViewTextBoxColumn As DataGridViewTextBoxColumn
    Friend WithEvents PVPBindingSource As BindingSource
End Class
