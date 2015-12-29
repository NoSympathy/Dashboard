<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class music
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
        Me.WebControl1 = New Awesomium.Windows.Forms.WebControl(Me.components)
        Me.SuspendLayout()
        '
        'WebControl1
        '
        Me.WebControl1.Dock = System.Windows.Forms.DockStyle.Fill
        Me.WebControl1.Location = New System.Drawing.Point(0, 0)
        Me.WebControl1.Size = New System.Drawing.Size(386, 339)
        Me.WebControl1.Source = New System.Uri("http://www.youtube.com/embed?listType=playlist&list=PLfhuRJY8whYCPeUgZRM2Gkm_lirS" &
        "UPMfP", System.UriKind.Absolute)
        Me.WebControl1.TabIndex = 0
        '
        'music
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(386, 339)
        Me.Controls.Add(Me.WebControl1)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.SizableToolWindow
        Me.Name = "music"
        Me.ShowIcon = False
        Me.ShowInTaskbar = False
        Me.Text = "music"
        Me.ResumeLayout(False)

    End Sub

    Private WithEvents WebControl1 As Awesomium.Windows.Forms.WebControl
End Class
