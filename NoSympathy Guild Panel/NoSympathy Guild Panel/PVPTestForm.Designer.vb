<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class PVPTestForm
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
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
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Me.RichTextBox1 = New System.Windows.Forms.RichTextBox()
        Me.LinkLabel1 = New System.Windows.Forms.LinkLabel()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.TextBox1 = New System.Windows.Forms.TextBox()
        Me.PVPBindingSource = New System.Windows.Forms.BindingSource(Me.components)
        Me.DataGridView1 = New System.Windows.Forms.DataGridView()
        Me.PvprankDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.AggregateDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.ProfessionsDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        Me.LaddersDataGridViewTextBoxColumn = New System.Windows.Forms.DataGridViewTextBoxColumn()
        CType(Me.PVPBindingSource, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.DataGridView1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'RichTextBox1
        '
        Me.RichTextBox1.Location = New System.Drawing.Point(12, 83)
        Me.RichTextBox1.Name = "RichTextBox1"
        Me.RichTextBox1.Size = New System.Drawing.Size(438, 505)
        Me.RichTextBox1.TabIndex = 11
        Me.RichTextBox1.Text = ""
        '
        'LinkLabel1
        '
        Me.LinkLabel1.AutoSize = True
        Me.LinkLabel1.Font = New System.Drawing.Font("Microsoft Sans Serif", 6.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.LinkLabel1.LinkColor = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.LinkLabel1.Location = New System.Drawing.Point(88, 32)
        Me.LinkLabel1.Name = "LinkLabel1"
        Me.LinkLabel1.Size = New System.Drawing.Size(46, 12)
        Me.LinkLabel1.TabIndex = 10
        Me.LinkLabel1.TabStop = True
        Me.LinkLabel1.Text = "API Key"
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Location = New System.Drawing.Point(25, 32)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(332, 13)
        Me.Label1.TabIndex = 9
        Me.Label1.Text = "Make a new                called ""My Toons"" and select Characters here"
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(249, 54)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(104, 23)
        Me.Button1.TabIndex = 8
        Me.Button1.Text = "Fetch My Toons"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Location = New System.Drawing.Point(398, 9)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(21, 13)
        Me.Label2.TabIndex = 14
        Me.Label2.Text = "{0}"
        '
        'TextBox1
        '
        Me.TextBox1.Location = New System.Drawing.Point(12, 9)
        Me.TextBox1.Name = "TextBox1"
        Me.TextBox1.Size = New System.Drawing.Size(345, 20)
        Me.TextBox1.TabIndex = 13
        Me.TextBox1.Text = "Add Account and Characters API Key"
        Me.TextBox1.TextAlign = System.Windows.Forms.HorizontalAlignment.Center
        '
        'PVPBindingSource
        '
        Me.PVPBindingSource.DataSource = GetType(Models.PVP)
        '
        'DataGridView1
        '
        Me.DataGridView1.AutoGenerateColumns = False
        Me.DataGridView1.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize
        Me.DataGridView1.Columns.AddRange(New System.Windows.Forms.DataGridViewColumn() {Me.PvprankDataGridViewTextBoxColumn, Me.AggregateDataGridViewTextBoxColumn, Me.ProfessionsDataGridViewTextBoxColumn, Me.LaddersDataGridViewTextBoxColumn})
        Me.DataGridView1.DataSource = Me.PVPBindingSource
        Me.DataGridView1.Location = New System.Drawing.Point(456, 12)
        Me.DataGridView1.Name = "DataGridView1"
        Me.DataGridView1.Size = New System.Drawing.Size(507, 150)
        Me.DataGridView1.TabIndex = 15
        '
        'PvprankDataGridViewTextBoxColumn
        '
        Me.PvprankDataGridViewTextBoxColumn.DataPropertyName = "pvp_rank"
        Me.PvprankDataGridViewTextBoxColumn.HeaderText = "pvp_rank"
        Me.PvprankDataGridViewTextBoxColumn.Name = "PvprankDataGridViewTextBoxColumn"
        '
        'AggregateDataGridViewTextBoxColumn
        '
        Me.AggregateDataGridViewTextBoxColumn.DataPropertyName = "aggregate"
        Me.AggregateDataGridViewTextBoxColumn.HeaderText = "aggregate"
        Me.AggregateDataGridViewTextBoxColumn.Name = "AggregateDataGridViewTextBoxColumn"
        '
        'ProfessionsDataGridViewTextBoxColumn
        '
        Me.ProfessionsDataGridViewTextBoxColumn.DataPropertyName = "professions"
        Me.ProfessionsDataGridViewTextBoxColumn.HeaderText = "professions"
        Me.ProfessionsDataGridViewTextBoxColumn.Name = "ProfessionsDataGridViewTextBoxColumn"
        '
        'LaddersDataGridViewTextBoxColumn
        '
        Me.LaddersDataGridViewTextBoxColumn.DataPropertyName = "ladders"
        Me.LaddersDataGridViewTextBoxColumn.HeaderText = "ladders"
        Me.LaddersDataGridViewTextBoxColumn.Name = "LaddersDataGridViewTextBoxColumn"
        '
        'PVPTestForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(970, 599)
        Me.Controls.Add(Me.DataGridView1)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.TextBox1)
        Me.Controls.Add(Me.RichTextBox1)
        Me.Controls.Add(Me.LinkLabel1)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.Button1)
        Me.Name = "PVPTestForm"
        Me.Text = "PVPTestForm"
        CType(Me.PVPBindingSource, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.DataGridView1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents RichTextBox1 As RichTextBox
    Friend WithEvents LinkLabel1 As LinkLabel
    Friend WithEvents Label1 As Label
    Friend WithEvents Button1 As Button
    Friend WithEvents Label2 As Label
    Friend WithEvents TextBox1 As TextBox
    Friend WithEvents PVPBindingSource As BindingSource
    Friend WithEvents DataGridView1 As DataGridView
    Friend WithEvents PvprankDataGridViewTextBoxColumn As DataGridViewTextBoxColumn
    Friend WithEvents AggregateDataGridViewTextBoxColumn As DataGridViewTextBoxColumn
    Friend WithEvents ProfessionsDataGridViewTextBoxColumn As DataGridViewTextBoxColumn
    Friend WithEvents LaddersDataGridViewTextBoxColumn As DataGridViewTextBoxColumn
End Class
