<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Settings
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
        Me.Button1 = New System.Windows.Forms.Button()
        Me.Button2 = New System.Windows.Forms.Button()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.TextBox1 = New System.Windows.Forms.TextBox()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.LinkLabelTp = New System.Windows.Forms.LinkLabel()
        Me.ToolTip1 = New System.Windows.Forms.ToolTip(Me.components)
        Me.MessageLabel1 = New System.Windows.Forms.Label()
        Me.ANetMyAccountAPI = New System.Windows.Forms.LinkLabel()
        Me.DeleteKeyBtn = New System.Windows.Forms.Button()
        Me.CopyButton = New System.Windows.Forms.Button()
        Me.SuspendLayout()
        '
        'Button1
        '
        Me.Button1.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!)
        Me.Button1.Location = New System.Drawing.Point(216, 42)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(47, 23)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Save"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'Button2
        '
        Me.Button2.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!)
        Me.Button2.Location = New System.Drawing.Point(617, 272)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(54, 23)
        Me.Button2.TabIndex = 1
        Me.Button2.Text = "Close"
        Me.Button2.UseVisualStyleBackColor = True
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(13, 13)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(52, 13)
        Me.Label1.TabIndex = 2
        Me.Label1.Text = "API Key"
        '
        'TextBox1
        '
        Me.TextBox1.Location = New System.Drawing.Point(75, 10)
        Me.TextBox1.Name = "TextBox1"
        Me.TextBox1.ReadOnly = True
        Me.TextBox1.Size = New System.Drawing.Size(570, 22)
        Me.TextBox1.TabIndex = 3
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Font = New System.Drawing.Font("MS Reference Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(95, 38)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(0, 15)
        Me.Label2.TabIndex = 4
        '
        'LinkLabelTp
        '
        Me.LinkLabelTp.AutoSize = True
        Me.LinkLabelTp.Font = New System.Drawing.Font("MS Reference Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.LinkLabelTp.LinkBehavior = System.Windows.Forms.LinkBehavior.NeverUnderline
        Me.LinkLabelTp.LinkColor = System.Drawing.Color.Green
        Me.LinkLabelTp.Location = New System.Drawing.Point(657, 13)
        Me.LinkLabelTp.Name = "LinkLabelTp"
        Me.LinkLabelTp.Size = New System.Drawing.Size(14, 15)
        Me.LinkLabelTp.TabIndex = 5
        Me.LinkLabelTp.TabStop = True
        Me.LinkLabelTp.Text = "?"
        Me.ToolTip1.SetToolTip(Me.LinkLabelTp, "No one will know or see your Personal API Key(s). " & Global.Microsoft.VisualBasic.ChrW(13) & Global.Microsoft.VisualBasic.ChrW(10) & "This is only exclusive to you" &
        " at all times!")
        Me.LinkLabelTp.VisitedLinkColor = System.Drawing.Color.Green
        '
        'ToolTip1
        '
        Me.ToolTip1.IsBalloon = True
        Me.ToolTip1.ToolTipIcon = System.Windows.Forms.ToolTipIcon.Info
        Me.ToolTip1.ToolTipTitle = "F.Y.I"
        '
        'MessageLabel1
        '
        Me.MessageLabel1.AutoSize = True
        Me.MessageLabel1.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!)
        Me.MessageLabel1.ForeColor = System.Drawing.Color.Green
        Me.MessageLabel1.Location = New System.Drawing.Point(280, 39)
        Me.MessageLabel1.Name = "MessageLabel1"
        Me.MessageLabel1.Size = New System.Drawing.Size(368, 26)
        Me.MessageLabel1.TabIndex = 6
        Me.MessageLabel1.Text = "You can add your API key by going to https://account.arena.net/applications ," & Global.Microsoft.VisualBasic.ChrW(13) & Global.Microsoft.VisualBasic.ChrW(10) & "ge" &
    "nerating a new key with all permissions and copy/pasting it into this form."
        '
        'ANetMyAccountAPI
        '
        Me.ANetMyAccountAPI.AutoSize = True
        Me.ANetMyAccountAPI.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!)
        Me.ANetMyAccountAPI.LinkColor = System.Drawing.Color.Red
        Me.ANetMyAccountAPI.Location = New System.Drawing.Point(459, 39)
        Me.ANetMyAccountAPI.Name = "ANetMyAccountAPI"
        Me.ANetMyAccountAPI.Size = New System.Drawing.Size(182, 13)
        Me.ANetMyAccountAPI.TabIndex = 8
        Me.ANetMyAccountAPI.TabStop = True
        Me.ANetMyAccountAPI.Text = "https://account.arena.net/applications"
        Me.ANetMyAccountAPI.VisitedLinkColor = System.Drawing.Color.Red
        '
        'DeleteKeyBtn
        '
        Me.DeleteKeyBtn.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!)
        Me.DeleteKeyBtn.Location = New System.Drawing.Point(75, 42)
        Me.DeleteKeyBtn.Name = "DeleteKeyBtn"
        Me.DeleteKeyBtn.Size = New System.Drawing.Size(113, 23)
        Me.DeleteKeyBtn.TabIndex = 9
        Me.DeleteKeyBtn.Text = "Delete Current Key"
        Me.DeleteKeyBtn.UseVisualStyleBackColor = True
        '
        'CopyButton
        '
        Me.CopyButton.BackColor = System.Drawing.SystemColors.GradientActiveCaption
        Me.CopyButton.FlatStyle = System.Windows.Forms.FlatStyle.Flat
        Me.CopyButton.Font = New System.Drawing.Font("Microsoft Sans Serif", 7.25!)
        Me.CopyButton.Location = New System.Drawing.Point(617, 9)
        Me.CopyButton.Name = "CopyButton"
        Me.CopyButton.Size = New System.Drawing.Size(28, 23)
        Me.CopyButton.TabIndex = 10
        Me.CopyButton.Text = "Copy"
        Me.CopyButton.UseVisualStyleBackColor = False
        '
        'Settings
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(8.0!, 16.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(683, 307)
        Me.ControlBox = False
        Me.Controls.Add(Me.CopyButton)
        Me.Controls.Add(Me.DeleteKeyBtn)
        Me.Controls.Add(Me.ANetMyAccountAPI)
        Me.Controls.Add(Me.MessageLabel1)
        Me.Controls.Add(Me.LinkLabelTp)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.TextBox1)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.Button1)
        Me.Font = New System.Drawing.Font("MS Reference Sans Serif", 9.0!)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.SizableToolWindow
        Me.Margin = New System.Windows.Forms.Padding(4)
        Me.MaximizeBox = False
        Me.Name = "Settings"
        Me.ShowIcon = False
        Me.ShowInTaskbar = False
        Me.SizeGripStyle = System.Windows.Forms.SizeGripStyle.Hide
        Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen
        Me.Text = "Settings"
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub

    Friend WithEvents Button1 As Button
    Friend WithEvents Button2 As Button
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents TextBox1 As System.Windows.Forms.TextBox
    Friend WithEvents Label2 As Label
    Friend WithEvents LinkLabelTp As LinkLabel
    Friend WithEvents ToolTip1 As ToolTip
    Friend WithEvents MessageLabel1 As Label
    Friend WithEvents ANetMyAccountAPI As LinkLabel
    Friend WithEvents DeleteKeyBtn As Button
    Friend WithEvents CopyButton As Button
End Class
